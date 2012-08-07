<?php
class uLogin {
    public $modx;
    public $settings = array();
    
    function __construct(&$modx, $settings){
        $this->modx = & $modx;
        $basePath = $this->modx->getOption('ulogin.core_path',$settings,$this->modx->getOption('core_path').'components/ulogin/');
        $this->settings = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'templatesPath' => $basePath.'templates/',
            'chunksPath' => $basePath.'elements/chunks/',
        ),$settings);   
        $this->modx->addPackage('ulogin',$this->settings['modelPath']);
    }
    
    public function initialize($properties = array()){
        if ($_POST['token'] && !$this->modx->user->isAuthenticated()){
            if ($user_data = $this->_checkToken()){
                $this->_proceedRegistration($user_data);
            }
        }else if($_REQUEST['action'] == 'signout') {
             $this->_signOut();
        }else if ($this->modx->user->isAuthenticated()){
            foreach ($properties as $key=>$value){
                $properties[$key] = trim($value, '\'\" ');
            }
            $properties['sigout_url'] = isset($properties['signouturl']) ? $properties['signouturl'] : $this->modx->makeUrl($this->modx->resource->id, '', '', 'full').'&action=signout';
            return $this->_getChunk($properties['usrpanel'], $properties);
        }else{
            foreach ($properties as $key=>$value){
                $properties[$key] = trim($value, '\'\" ');
            }
            $template = $properties['display'] == 'window' ? 'window' : 'panel';
            return $this->_getChunk($template, $properties);
        }
    }
    
    private function _checkToken(){
        if (strlen($_POST['token']) != 32){
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[uLogin] ERROR: Invalid token '.$_POST['token']);
        }else{
            $json_data = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
            $user_data = json_decode($json_data, true);
            if (isset($user_data['error'])){
                $this->modx->log(modX::LOG_LEVEL_ERROR, '[uLogin] ERROR: '.$user_data['error']);
            }else{
                return $user_data;
            }
        }
        return false;
    }
    
    private function _signOut(){
        $response = $this->modx->runProcessor('/security/logout');
        if ($response->isError()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[uLogin] ERROR: Username: '.$this->modx->user->get('username').', uid: '.$this->modx->user->get('id').'. Message: '.$response->getMessage());
        }
        $this->modx->sendRedirect($this->modx->makeUrl($this->modx->resource->id), array('type'=>'REDIRECT_REFRESH'));
    }

    private function _proceedRegistration($data){
        $identity = parse_url($data['identity']);
        $dob = explode('.', $user_raw->bdate);
        $UserData['Password'] = md5(urlencode($identity['query'].'_'.$identity['path']));
        $UserData['Name'] = (isset($data['nickname']) ? $data['nickname'] : $data['last_name'].' '.$data['first_name']).' '.time();
        $UserData['Email'] = strpos($data['manual'],'email')===FALSE ? time().'_'.$data['email']: time().'_umf_'.$data['email'];
        $UserData['DateOfBirth'] = strtotime($data['bdate']);
        $UserData['Gender'] = $data['sex'] == '1' ? '2' : '1';
        $user = $this->modx->getObject('uLoginUser', array('identity' => $data['identity']));
        if ($user) {
            $modxProfile = $this->modx->newObject('modUserProfile');
            $modXuser = $this->modx->getObject('modUser', array('id'=>intval($user->get('user_id'))));
            if (!$modXuser){
                while ($this->modx->getObject('modUser', array('username'=>$UserData['Name']))){
                    $UserData['Name'] = (isset($data['nickname']) ? $data['nickname'].' '.time() : $data['last_name'].' '.$data['first_name']).' '.time();
                }
                $modXuser = $this->modx->newObject('modUser', array('username' => $UserData['Name'], 'password' => $UserData['Password'], 'active'=>1));
                $modXuser->addOne($modxProfile);
                $modXuser->save();
                
                $modxProfile->set('fullname', $data['last_name'].' '.$data['first_name']);
                $modxProfile->set('dob', $UserData['DateOfBirth']);
                $modxProfile->set('gender', $UserData['Gender']);
                $modxProfile->set('website', $data['identity']);
                
                $user->set('user_id',$modXuser->get('id'));
                $user->save();
            } else {
                $modXuser->addOne($modxProfile); 
                $modXuser->save();
            }
            $modxProfile->set('country', $data['country']);
            $modxProfile->set('city', $data['city']);
            $modxProfile->set('email', $UserData['Email']);
            $modxProfile->set('photo', $data['photo']);
            $modxProfile->save();

            $response = $this->modx->runProcessor('/security/login', array('username' => $modXuser->get('username'),'password' => $UserData['Password'] ,'login_context'=>'web', 'add_contexts'=>''));
            if ($response->isError()) {
                $this->modx->log(modX::LOG_LEVEL_ERROR, '[uLogin] ERROR : Username: '.$modXuser->get('username').', uid: '.$modXuser->get('id').', pass:'.$modXuser->get('password').'. Message: '.$response->getMessage());
            }
        }else{
            while ($this->modx->getObject('modUser', array('username'=>$UserData['Name']))){
                    $UserData['Name'] = (isset($data['nickname']) ? $data['nickname'].' '.time() : $data['last_name'].' '.$data['first_name']).' '.time();
            }
            $modXuser = $this->modx->newObject('modUser', array('username' => $UserData['Name'], 'password' => $UserData['Password'], 'active'=>1));
            $modxProfile = $this->modx->newObject('modUserProfile');
            $modXuser->addOne($modxProfile);
            $modXuser->save();

            $modxProfile->set('fullname', $data['last_name'].' '.$data['first_name']);
            $modxProfile->set('email', $UserData['Email']);
            $modxProfile->set('dob', $UserData['DateOfBirth']);
            $modxProfile->set('gender', $UserData['Gender']);
            $modxProfile->set('country', $data['country']);
            $modxProfile->set('city', $data['city']);
            $modxProfile->set('website', $data['identity']);
            $modxProfile->set('photo', $data['photo']);
            
            $modxProfile->save();
            
            $user = $this->modx->newObject('uLoginUser');
            $user->fromArray(array(
                'user_id' => intval($modXuser->get('id')),
                'identity' => strval($data['identity']),
            ));
            $user->save();
            
            
            $response = $this->modx->runProcessor('/security/login', array('username' => $UserData['Name'],'password' =>  $UserData['Password'],'login_context'=>'web', 'add_contexts'=>''));
            if ($response->isError()) {
                $this->modx->log(modX::LOG_LEVEL_ERROR, '[uLogin] ERROR : Username: '.$UserData['Name'].', uid: '.$modXuser->get('id').'. Message: '.$response->getMessage());
            }
        }
        $this->modx->sendRedirect($this->modx->makeUrl($this->modx->resource->id), array('type'=>'REDIRECT_REFRESH'));
    }
    
    
    
    private function _getChunk($name,$properties = array()) {
    $chunk = null;
    if (!isset($this->chunks[$name])) {
        $chunk = $this->_getTplChunk($name);
        if (empty($chunk)) {
            $chunk = $this->modx->getObject('modChunk',array('name' => $name));
            if ($chunk == false) return false;
        }
        $this->chunks[$name] = $chunk->getContent();
    } else {
        $o = $this->chunks[$name];
        $chunk = $this->modx->newObject('modChunk');
        $chunk->setContent($o);
    }
    $chunk->setCacheable(false);
    return $chunk->process($properties);
}
 
    private function _getTplChunk($name,$postfix = '.chunk.tpl') {
        $chunk = false;
        $f = $this->settings['chunksPath'].strtolower($name).$postfix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }
}
?>
