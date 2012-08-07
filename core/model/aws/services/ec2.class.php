<?php
/*
 * Copyright 2010-2011 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

/**
 *
 * Amazon Elastic Compute Cloud (Amazon EC2) is a web service that provides resizable compute capacity in the cloud. It is designed to make
 * web-scale computing easier for developers.
 *
 * Amazon EC2's simple web service interface allows you to obtain and configure capacity with minimal friction. It provides you with complete
 * control of your computing resources and lets you run on Amazon's proven computing environment. Amazon EC2 reduces the time required to
 * obtain and boot new server instances to minutes, allowing you to quickly scale capacity, both up and down, as your computing requirements
 * change. Amazon EC2 changes the economics of computing by allowing you to pay only for capacity that you actually use. Amazon EC2 provides
 * developers the tools to build failure resilient applications and isolate themselves from common failure scenarios.
 *
 * Visit <a href="http://aws.amazon.com/ec2/">http://aws.amazon.com/ec2/</a> for more information.
 *
 * @version Tue Aug 23 12:47:35 PDT 2011
 * @license See the included NOTICE.md file for complete information.
 * @copyright See the included NOTICE.md file for complete information.
 * @link http://aws.amazon.com/ec2/Amazon Elastic Compute Cloud
 * @link http://aws.amazon.com/documentation/ec2/Amazon Elastic Compute Cloud documentation
 */
class AmazonEC2 extends CFRuntime
{

	/*%******************************************************************************************%*/
	// CLASS CONSTANTS

	/**
	 * Specify the default queue URL.
	 */
	const DEFAULT_URL = 'ec2.amazonaws.com';

	/**
	 * Specify the queue URL for the US-East (Northern Virginia) Region.
	 */
	const REGION_US_E1 = 'us-east-1';

	/**
	 * Specify the queue URL for the US-West (Northern California) Region.
	 */
	const REGION_US_W1 = 'us-west-1';

	/**
	 * Specify the queue URL for the EU (Ireland) Region.
	 */
	const REGION_EU_W1 = 'eu-west-1';

	/**
	 * Specify the queue URL for the Asia Pacific (Singapore) Region.
	 */
	const REGION_APAC_SE1 = 'ap-southeast-1';

	/**
	 * Specify the queue URL for the Asia Pacific (Japan) Region.
	 */
	const REGION_APAC_NE1 = 'ap-northeast-1';

	/**
	 * The "pending" state code of an EC2 instance. Useful for conditionals.
	 */
	const STATE_PENDING = 0;

	/**
	 * The "running" state code of an EC2 instance. Useful for conditionals.
	 */
	const STATE_RUNNING = 16;

	/**
	 * The "shutting-down" state code of an EC2 instance. Useful for conditionals.
	 */
	const STATE_SHUTTING_DOWN = 32;

	/**
	 * The "terminated" state code of an EC2 instance. Useful for conditionals.
	 */
	const STATE_TERMINATED = 48;

	/**
	 * The "stopping" state code of an EC2 instance. Useful for conditionals.
	 */
	const STATE_STOPPING = 64;

	/**
	 * The "stopped" state code of an EC2 instance. Useful for conditionals.
	 */
	const STATE_STOPPED = 80;


	/*%******************************************************************************************%*/
	// SETTERS

	/**
	 * This allows you to explicitly sets the region for the service to use.
	 *
	 * @param string $region (Required) The region to explicitly set. Available options are <REGION_US_E1>, <REGION_US_W1>, <REGION_EU_W1>, or <REGION_APAC_SE1>.
	 * @return $this A reference to the current instance.
	 */
	public function set_region($region)
	{
		$this->set_hostname('http://ec2.'. $region .'.amazonaws.com');
		return $this;
	}


	/*%******************************************************************************************%*/
	// CONSTRUCTOR

	/**
	 * Constructs a new instance of <AmazonEC2>. If the <code>AWS_DEFAULT_CACHE_CONFIG</code> configuration
	 * option is set, requests will be authenticated using a session token. Otherwise, requests will use
	 * the older authentication method.
	 *
	 * @param string $key (Optional) Your AWS key, or a session key. If blank, it will look for the <code>AWS_KEY</code> constant.
	 * @param string $secret_key (Optional) Your AWS secret key, or a session secret key. If blank, it will look for the <code>AWS_SECRET_KEY</code> constant.
	 * @param string $token (optional) An AWS session token. If blank, a request will be made to the AWS Secure Token Service to fetch a set of session credentials.
	 * @return boolean A value of <code>false</code> if no valid values are set, otherwise <code>true</code>.
	 */
	public function __construct($key = null, $secret_key = null, $token = null)
	{
		$this->api_version = '2011-02-28';
		$this->hostname = self::DEFAULT_URL;

		if (!$key && !defined('AWS_KEY'))
		{
			// @codeCoverageIgnoreStart
			throw new EC2_Exception('No account key was passed into the constructor, nor was it set in the AWS_KEY constant.');
			// @codeCoverageIgnoreEnd
		}

		if (!$secret_key && !defined('AWS_SECRET_KEY'))
		{
			// @codeCoverageIgnoreStart
			throw new EC2_Exception('No account secret was passed into the constructor, nor was it set in the AWS_SECRET_KEY constant.');
			// @codeCoverageIgnoreEnd
		}

		if (defined('AWS_DEFAULT_CACHE_CONFIG') && AWS_DEFAULT_CACHE_CONFIG)
		{
			return parent::session_based_auth($key, $secret_key, $token);
		}

		return parent::__construct($key, $secret_key);
	}


	/*%******************************************************************************************%*/
	// SERVICE METHODS

	/**
	 *
	 * The RebootInstances operation requests a reboot of one or more instances. This operation is asynchronous; it only queues a request to
	 * reboot the specified instance(s). The operation will succeed if the instances are valid and belong to the user. Requests to reboot
	 * terminated instances are ignored.
	 *
	 * @param string|array $instance_id (Required) The list of instances to terminate.  Pass a string for a single value, or an indexed array for multiple values.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function reboot_instances($instance_id, $opt = null)
	{
		if (!$opt) $opt = array();

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'InstanceId' => (is_array($instance_id) ? $instance_id : array($instance_id))
		)));

		return $this->authenticate('RebootInstances', $opt, $this->hostname);
	}

	/**
	 *
	 * The DescribeReservedInstances operation describes Reserved Instances that were purchased for use with your account.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>ReservedInstancesId</code> - <code>string|array</code> - Optional - The optional list of Reserved Instance IDs to describe.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>Filter</code> - <code>array</code> - Optional - A list of filters used to match properties for ReservedInstances. For a complete reference to the available filter keys for this operation, see the Amazon EC2 API reference. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>Name</code> - <code>string</code> - Optional - Specifies the name of the filter. </li>
	 * 			<li><code>Value</code> - <code>string|array</code> - Optional - Contains one or more values for the filter.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_reserved_instances($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['ReservedInstancesId']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'ReservedInstancesId' => (is_array($opt['ReservedInstancesId']) ? $opt['ReservedInstancesId'] : array($opt['ReservedInstancesId']))
			)));
			unset($opt['ReservedInstancesId']);
		}

		// Optional parameter
		if (isset($opt['Filter']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Filter' => $opt['Filter']
			)));
			unset($opt['Filter']);
		}

		return $this->authenticate('DescribeReservedInstances', $opt, $this->hostname);
	}

	/**
	 *
	 * The DescribeAvailabilityZones operation describes availability zones that are currently available to the account and their states.
	 *
	 * Availability zones are not the same across accounts. The availability zone <code>us-east-1a</code> for account A is not necessarily the
	 * same as <code>us-east-1a</code> for account B. Zone assignments are mapped independently for each account.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>ZoneName</code> - <code>string|array</code> - Optional - A list of the availability zone names to describe.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>Filter</code> - <code>array</code> - Optional - A list of filters used to match properties for AvailabilityZones. For a complete reference to the available filter keys for this operation, see the Amazon EC2 API reference. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>Name</code> - <code>string</code> - Optional - Specifies the name of the filter. </li>
	 * 			<li><code>Value</code> - <code>string|array</code> - Optional - Contains one or more values for the filter.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_availability_zones($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['ZoneName']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'ZoneName' => (is_array($opt['ZoneName']) ? $opt['ZoneName'] : array($opt['ZoneName']))
			)));
			unset($opt['ZoneName']);
		}

		// Optional parameter
		if (isset($opt['Filter']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Filter' => $opt['Filter']
			)));
			unset($opt['Filter']);
		}

		return $this->authenticate('DescribeAvailabilityZones', $opt, $this->hostname);
	}

	/**
	 *
	 * Detach a previously attached volume from a running instance.
	 *
	 * @param string $volume_id (Required) The ID of the volume to detach.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>InstanceId</code> - <code>string</code> - Optional - The ID of the instance from which to detach the the specified volume. </li>
	 * 	<li><code>Device</code> - <code>string</code> - Optional - The device name to which the volume is attached on the specified instance. </li>
	 * 	<li><code>Force</code> - <code>boolean</code> - Optional - Forces detachment if the previous detachment attempt did not occur cleanly (logging into an instance, unmounting the volume, and detaching normally). This option can lead to data loss or a corrupted file system. Use this option only as a last resort to detach a volume from a failed instance. The instance will not have an opportunity to flush file system caches nor file system meta data. If you use this option, you must perform file system check and repair procedures. </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function detach_volume($volume_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['VolumeId'] = $volume_id;

		return $this->authenticate('DetachVolume', $opt, $this->hostname);
	}

	/**
	 *
	 * The DeleteKeyPair operation deletes a key pair.
	 *
	 * @param string $key_name (Required) The name of the Amazon EC2 key pair to delete.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_key_pair($key_name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['KeyName'] = $key_name;

		return $this->authenticate('DeleteKeyPair', $opt, $this->hostname);
	}

	/**
	 *
	 * Disables monitoring for a running instance.
	 *
	 * @param string|array $instance_id (Required) The list of Amazon EC2 instances on which to disable monitoring.  Pass a string for a single value, or an indexed array for multiple values.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function unmonitor_instances($instance_id, $opt = null)
	{
		if (!$opt) $opt = array();

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'InstanceId' => (is_array($instance_id) ? $instance_id : array($instance_id))
		)));

		return $this->authenticate('UnmonitorInstances', $opt, $this->hostname);
	}

	/**
	 *
	 * Attaches a VPN gateway to a VPC. This is the last step required to get your VPC fully connected to your data center before launching
	 * instances in it. For more information, go to Process for Using Amazon VPC in the Amazon Virtual Private Cloud Developer Guide.
	 *
	 * @param string $vpn_gateway_id (Required) The ID of the VPN gateway to attach to the VPC.
	 * @param string $vpc_id (Required) The ID of the VPC to attach to the VPN gateway.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function attach_vpn_gateway($vpn_gateway_id, $vpc_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['VpnGatewayId'] = $vpn_gateway_id;
		$opt['VpcId'] = $vpc_id;

		return $this->authenticate('AttachVpnGateway', $opt, $this->hostname);
	}

	/**
	 *
	 * Creates an Amazon EBS-backed AMI from a "running" or "stopped" instance. AMIs that use an Amazon EBS root device boot faster than AMIs that
	 * use instance stores. They can be up to 1 TiB in size, use storage that persists on instance failure, and can be stopped and started.
	 *
	 * @param string $instance_id (Required) The ID of the instance from which to create the new image.
	 * @param string $name (Required) The name for the new AMI being created.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Description</code> - <code>string</code> - Optional - The description for the new AMI being created. </li>
	 * 	<li><code>NoReboot</code> - <code>boolean</code> - Optional - By default this property is set to <code>false</code>, which means Amazon EC2 attempts to cleanly shut down the instance before image creation and reboots the instance afterwards. When set to true, Amazon EC2 will not shut down the instance before creating the image. When this option is used, file system integrity on the created image cannot be guaranteed. </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_image($instance_id, $name, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['InstanceId'] = $instance_id;
		$opt['Name'] = $name;

		return $this->authenticate('CreateImage', $opt, $this->hostname);
	}

	/**
	 *
	 * The DeleteSecurityGroup operation deletes a security group.
	 *
	 * If you attempt to delete a security group that contains instances, a fault is returned.
	 *
	 * If you attempt to delete a security group that is referenced by another security group, a fault is returned. For example, if security group
	 * B has a rule that allows access from security group A, security group A cannot be deleted until the allow rule is removed.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GroupName</code> - <code>string</code> - Optional - The name of the Amazon EC2 security group to delete. </li>
	 * 	<li><code>GroupId</code> - <code>string</code> - Optional - The ID of the Amazon EC2 security group to delete. </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_security_group($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DeleteSecurityGroup', $opt, $this->hostname);
	}

	/**
	 *
	 * This action applies only to security groups in a VPC; it's not supported for EC2 security groups. For information about Amazon Virtual
	 * Private Cloud and VPC security groups, go to the Amazon Virtual Private Cloud User Guide.
	 *
	 * The action adds one or more egress rules to a VPC security group. Specifically, this permits instances in a security group to send traffic
	 * to either one or more destination CIDR IP address ranges, or to one or more destination security groups in the same VPC.
	 *
	 * Each rule consists of the protocol (e.g., TCP), plus either a CIDR range, or a source group. For the TCP and UDP protocols, you must also
	 * specify the destination port or port range. For the ICMP protocol, you must also specify the ICMP type and code. You can use <code>-1</code>
	 * as a wildcard for the ICMP type or code.
	 *
	 * Rule changes are propagated to instances within the security group as quickly as possible. However, a small delay might occur.
	 *
	 * <b>Important: </b> For VPC security groups: You can have up to 50 rules total per group (covering both ingress and egress).
	 *
	 * @param string $group_id (Required) ID of the VPC security group to modify.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>IpPermissions</code> - <code>array</code> - Optional - List of IP permissions to authorize on the specified security group. Specifying permissions through IP permissions is the preferred way of authorizing permissions since it offers more flexibility and control. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>IpProtocol</code> - <code>string</code> - Optional - The IP protocol of this permission. Valid protocol values: <code>tcp</code>, <code>udp</code>, <code>icmp</code> </li>
	 * 			<li><code>FromPort</code> - <code>integer</code> - Optional - Start of port range for the TCP and UDP protocols, or an ICMP type number. An ICMP type number of <code>-1</code> indicates a wildcard (i.e., any ICMP type number). </li>
	 * 			<li><code>ToPort</code> - <code>integer</code> - Optional - End of port range for the TCP and UDP protocols, or an ICMP code. An ICMP code of <code>-1</code> indicates a wildcard (i.e., any ICMP code). </li>
	 * 			<li><code>Groups</code> - <code>array</code> - Optional - The list of AWS user IDs and groups included in this permission. <ul>
	 * 				<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 					<li><code>UserId</code> - <code>string</code> - Optional - The AWS user ID of an account. </li>
	 * 					<li><code>GroupName</code> - <code>string</code> - Optional - Name of the security group in the specified AWS account. Cannot be used when specifying a CIDR IP address range. </li>
	 * 					<li><code>GroupId</code> - <code>string</code> - Optional - ID of the security group in the specified AWS account. Cannot be used when specifying a CIDR IP address range. </li>
	 * 				</ul></li>
	 * 			</ul></li>
	 * 			<li><code>IpRanges</code> - <code>string|array</code> - Optional - The list of CIDR IP ranges included in this permission.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function authorize_security_group_egress($group_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupId'] = $group_id;

		// Optional parameter
		if (isset($opt['IpPermissions']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'IpPermissions' => $opt['IpPermissions']
			)));
			unset($opt['IpPermissions']);
		}

		return $this->authenticate('AuthorizeSecurityGroupEgress', $opt, $this->hostname);
	}

	/**
	 * Retrieves the encrypted administrator password for the instances running Windows.
	 *
	 * The Windows password is only generated the first time an AMI is launched. It is not generated for
	 * rebundled AMIs or after the password is changed on an instance. The password is encrypted using the
	 * key pair that you provided.
	 *
	 * @param string $instance_id (Required) The ID of the instance for which you want the Windows administrator password.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>DecryptPasswordWithKey</code> - <code>string</code> - Optional - Enables the decryption of the Administrator password for the given Microsoft Windows instance. Specifies the RSA private key that is associated with the keypair ID which was used to launch the Microsoft Windows instance.</li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 *  <li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This is useful for manually-managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function get_password_data($instance_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['InstanceId'] = $instance_id;

		// Unless DecryptPasswordWithKey is set, simply return the response.
		if (!isset($opt['DecryptPasswordWithKey']))
		{
			return $this->authenticate('GetPasswordData', $opt, $this->hostname);
		}

		// Otherwise, decrypt the password.
		else
		{
			// Get a resource representing the private key.
			$private_key = openssl_pkey_get_private($opt['DecryptPasswordWithKey']);
			unset($opt['DecryptPasswordWithKey']);

			// Fetch the encrypted password.
			$response = $this->authenticate('GetPasswordData', $opt, $this->hostname);
			$data = trim((string) $response->body->passwordData);

			// If it's Base64-encoded...
			if ($this->util->is_base64($data))
			{
				// Base64-decode it, and decrypt it with the private key.
				if (openssl_private_decrypt(base64_decode($data), $decrypted, $private_key))
				{
					// Replace the previous password data with the decrypted value.
					$response->body->passwordData = $decrypted;
				}
			}

			return $response;
		}
	}

	/**
	 *
	 * Associates a set of DHCP options (that you've previously created) with the specified VPC. Or, associates the default DHCP options with the
	 * VPC. The default set consists of the standard EC2 host name, no domain name, no DNS server, no NTP server, and no NetBIOS server or node
	 * type. After you associate the options with the VPC, any existing instances and all new instances that you launch in that VPC use the
	 * options. For more information about the supported DHCP options and using them with Amazon VPC, go to Using DHCP Options in the Amazon
	 * Virtual Private Cloud Developer Guide.
	 *
	 * @param string $dhcp_options_id (Required) The ID of the DHCP options to associate with the VPC. Specify "default" to associate the default DHCP options with the VPC.
	 * @param string $vpc_id (Required) The ID of the VPC to associate the DHCP options with.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function associate_dhcp_options($dhcp_options_id, $vpc_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['DhcpOptionsId'] = $dhcp_options_id;
		$opt['VpcId'] = $vpc_id;

		return $this->authenticate('AssociateDhcpOptions', $opt, $this->hostname);
	}

	/**
	 *
	 * Stops an instance that uses an Amazon EBS volume as its root device. Instances that use Amazon EBS volumes as their root devices can be
	 * quickly stopped and started. When an instance is stopped, the compute resources are released and you are not billed for hourly instance
	 * usage. However, your root partition Amazon EBS volume remains, continues to persist your data, and you are charged for Amazon EBS volume
	 * usage. You can restart your instance at any time.
	 *
	 * Before stopping an instance, make sure it is in a state from which it can be restarted. Stopping an instance does not preserve data stored
	 * in RAM.
	 *
	 * Performing this operation on an instance that uses an instance store as its root device returns an error.
	 *
	 * @param string|array $instance_id (Required) The list of Amazon EC2 instances to stop.  Pass a string for a single value, or an indexed array for multiple values.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Force</code> - <code>boolean</code> - Optional - Forces the instance to stop. The instance will not have an opportunity to flush file system caches nor file system meta data. If you use this option, you must perform file system check and repair procedures. This option is not recommended for Windows instances. </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function stop_instances($instance_id, $opt = null)
	{
		if (!$opt) $opt = array();

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'InstanceId' => (is_array($instance_id) ? $instance_id : array($instance_id))
		)));

		return $this->authenticate('StopInstances', $opt, $this->hostname);
	}

	/**
	 * Imports the public key from an RSA key pair created with a third-party tool. This operation differs
	 * from CreateKeyPair as the private key is never transferred between the caller and AWS servers.
	 *
	 * RSA key pairs are easily created on Microsoft Windows and Linux OS systems using the <code>ssh-keygen</code>
	 * command line tool provided with the standard OpenSSH installation. Standard library support for RSA
	 * key pair creation is also available for Java, Ruby, Python, and many other programming languages.
	 *
	 * The following formats are supported:
	 *
	 * <ul>
	 * 	<li>OpenSSH public key format.</li>
	 * 	<li>Base64 encoded DER format.</li>
	 * 	<li>SSH public key file format as specified in <a href="http://tools.ietf.org/html/rfc4716">RFC 4716</a>.</li>
	 * </ul>
	 *
	 * @param string $key_name (Required) The unique name for the key pair.
	 * @param string $public_key_material (Required) The public key portion of the key pair being imported.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 *  <li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This is useful for manually-managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function import_key_pair($key_name, $public_key_material, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['KeyName'] = $key_name;
		$opt['PublicKeyMaterial'] = $this->util->is_base64($public_key_material) ? $public_key_material : base64_encode($public_key_material);

		return $this->authenticate('ImportKeyPair', $opt, $this->hostname);
	}

	/**
	 *
	 * The CreateSecurityGroup operation creates a new security group.
	 *
	 * Every instance is launched in a security group. If no security group is specified during launch, the instances are launched in the default
	 * security group. Instances within the same security group have unrestricted network access to each other. Instances will reject network
	 * access attempts from other instances in a different security group. As the owner of instances you can grant or revoke specific permissions
	 * using the AuthorizeSecurityGroupIngress and RevokeSecurityGroupIngress operations.
	 *
	 * @param string $group_name (Required) Name of the security group.
	 * @param string $group_description (Required) Description of the group. This is informational only.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VpcId</code> - <code>string</code> - Optional - ID of the VPC. </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_security_group($group_name, $group_description, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['GroupName'] = $group_name;
		$opt['GroupDescription'] = $group_description;

		return $this->authenticate('CreateSecurityGroup', $opt, $this->hostname);
	}

	/**
	 *
	 * Describes the Spot Price history.
	 *
	 * Spot Instances are instances that Amazon EC2 starts on your behalf when the maximum price that you specify exceeds the current Spot Price.
	 * Amazon EC2 periodically sets the Spot Price based on available Spot Instance capacity and current spot instance requests.
	 *
	 * For conceptual information about Spot Instances, refer to the Amazon Elastic Compute Cloud Developer Guide or Amazon Elastic Compute Cloud
	 * User Guide.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>StartTime</code> - <code>string</code> - Optional - The start date and time of the Spot Instance price history data. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	<li><code>EndTime</code> - <code>string</code> - Optional - The end date and time of the Spot Instance price history data. May be passed as a number of seconds since UNIX Epoch, or any string compatible with <php:strtotime()>.</li>
	 * 	<li><code>InstanceType</code> - <code>string|array</code> - Optional - Specifies the instance type to return.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>ProductDescription</code> - <code>string|array</code> - Optional - The description of the AMI.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>Filter</code> - <code>array</code> - Optional - A list of filters used to match properties for SpotPriceHistory. For a complete reference to the available filter keys for this operation, see the Amazon EC2 API reference. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>Name</code> - <code>string</code> - Optional - Specifies the name of the filter. </li>
	 * 			<li><code>Value</code> - <code>string|array</code> - Optional - Contains one or more values for the filter.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>AvailabilityZone</code> - <code>string</code> - Optional - Filters the results by availability zone (ex: 'us-east-1a'). </li>
	 * 	<li><code>MaxResults</code> - <code>integer</code> - Optional - Specifies the number of rows to return. </li>
	 * 	<li><code>NextToken</code> - <code>string</code> - Optional - Specifies the next set of rows to return. </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_spot_price_history($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['StartTime']))
		{
			$opt['StartTime'] = $this->util->convert_date_to_iso8601($opt['StartTime']);
		}

		// Optional parameter
		if (isset($opt['EndTime']))
		{
			$opt['EndTime'] = $this->util->convert_date_to_iso8601($opt['EndTime']);
		}

		// Optional parameter
		if (isset($opt['InstanceType']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'InstanceType' => (is_array($opt['InstanceType']) ? $opt['InstanceType'] : array($opt['InstanceType']))
			)));
			unset($opt['InstanceType']);
		}

		// Optional parameter
		if (isset($opt['ProductDescription']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'ProductDescription' => (is_array($opt['ProductDescription']) ? $opt['ProductDescription'] : array($opt['ProductDescription']))
			)));
			unset($opt['ProductDescription']);
		}

		// Optional parameter
		if (isset($opt['Filter']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Filter' => $opt['Filter']
			)));
			unset($opt['Filter']);
		}

		return $this->authenticate('DescribeSpotPriceHistory', $opt, $this->hostname);
	}

	/**
	 *
	 * The DescribeRegions operation describes regions zones that are currently available to the account.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>RegionName</code> - <code>string|array</code> - Optional - The optional list of regions to describe.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>Filter</code> - <code>array</code> - Optional - A list of filters used to match properties for Regions. For a complete reference to the available filter keys for this operation, see the Amazon EC2 API reference. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>Name</code> - <code>string</code> - Optional - Specifies the name of the filter. </li>
	 * 			<li><code>Value</code> - <code>string|array</code> - Optional - Contains one or more values for the filter.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_regions($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['RegionName']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'RegionName' => (is_array($opt['RegionName']) ? $opt['RegionName'] : array($opt['RegionName']))
			)));
			unset($opt['RegionName']);
		}

		// Optional parameter
		if (isset($opt['Filter']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Filter' => $opt['Filter']
			)));
			unset($opt['Filter']);
		}

		return $this->authenticate('DescribeRegions', $opt, $this->hostname);
	}

	/**
	 *
	 * Creates a set of DHCP options that you can then associate with one or more VPCs, causing all existing and new instances that you launch in
	 * those VPCs to use the set of DHCP options. The following table lists the individual DHCP options you can specify. For more information about
	 * the options, go to <a href="http://www.ietf.org/rfc/rfc2132.txt">http://www.ietf.org/rfc/rfc2132.txt</a>
	 *
	 * @param array $dhcp_configuration (Required) A set of one or more DHCP configurations. <ul>
	 * 	<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 		<li><code>Key</code> - <code>string</code> - Optional - Contains the name of a DHCP option. </li>
	 * 		<li><code>Value</code> - <code>string|array</code> - Optional - Contains a set of values for a DHCP option.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	</ul></li>
	 * </ul>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_dhcp_options($dhcp_configuration, $opt = null)
	{
		if (!$opt) $opt = array();

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'DhcpConfiguration' => (is_array($dhcp_configuration) ? $dhcp_configuration : array($dhcp_configuration))
		)));

		return $this->authenticate('CreateDhcpOptions', $opt, $this->hostname);
	}

	/**
	 *
	 * Resets permission settings for the specified snapshot.
	 *
	 * @param string $snapshot_id (Required) The ID of the snapshot whose attribute is being reset.
	 * @param string $attribute (Required) The name of the attribute being reset. Available attribute names: <code>createVolumePermission</code>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function reset_snapshot_attribute($snapshot_id, $attribute, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['SnapshotId'] = $snapshot_id;
		$opt['Attribute'] = $attribute;

		return $this->authenticate('ResetSnapshotAttribute', $opt, $this->hostname);
	}

	/**
	 *
	 * Deletes a route from a route table in a VPC. For more information about route tables, go to <a
	 * href="http://docs.amazonwebservices.com/AmazonVPC/latest/UserGuide/VPC_Route_Tables.html">Route Tables</a> in the Amazon Virtual Private
	 * Cloud User Guide.
	 *
	 * @param string $route_table_id (Required) The ID of the route table where the route will be deleted.
	 * @param string $destination_cidr_block (Required) The CIDR range for the route you want to delete. The value you specify must exactly match the CIDR for the route you want to delete.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_route($route_table_id, $destination_cidr_block, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['RouteTableId'] = $route_table_id;
		$opt['DestinationCidrBlock'] = $destination_cidr_block;

		return $this->authenticate('DeleteRoute', $opt, $this->hostname);
	}

	/**
	 *
	 * Gives you information about your Internet gateways. You can filter the results to return information only about Internet gateways that
	 * match criteria you specify. For example, you could get information only about gateways with particular tags. The Internet gateway must match
	 * at least one of the specified values for it to be included in the results.
	 *
	 * You can specify multiple filters (e.g., the Internet gateway is attached to a particular VPC and is tagged with a particular value). The
	 * result includes information for a particular Internet gateway only if the gateway matches all your filters. If there's no match, no special
	 * message is returned; the response is simply empty.
	 *
	 * You can use wildcards with the filter values: an asterisk matches zero or more characters, and <code>?</code> matches exactly one
	 * character. You can escape special characters using a backslash before the character. For example, a value of <code>\*amazon\?\\</code>
	 * searches for the literal string <code>*amazon?\</code>.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>InternetGatewayId</code> - <code>string|array</code> - Optional - One or more Internet gateway IDs.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>Filter</code> - <code>array</code> - Optional - A list of filters used to match properties for Internet Gateways. For a complete reference to the available filter keys for this operation, see the Amazon EC2 API reference. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>Name</code> - <code>string</code> - Optional - Specifies the name of the filter. </li>
	 * 			<li><code>Value</code> - <code>string|array</code> - Optional - Contains one or more values for the filter.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_internet_gateways($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['InternetGatewayId']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'InternetGatewayId' => (is_array($opt['InternetGatewayId']) ? $opt['InternetGatewayId'] : array($opt['InternetGatewayId']))
			)));
			unset($opt['InternetGatewayId']);
		}

		// Optional parameter
		if (isset($opt['Filter']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Filter' => $opt['Filter']
			)));
			unset($opt['Filter']);
		}

		return $this->authenticate('DescribeInternetGateways', $opt, $this->hostname);
	}

	/**
	 *
	 * The DescribeSecurityGroups operation returns information about security groups that you own.
	 *
	 * If you specify security group names, information about those security group is returned. Otherwise, information for all security group is
	 * returned. If you specify a group that does not exist, a fault is returned.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>GroupName</code> - <code>string|array</code> - Optional - The optional list of Amazon EC2 security groups to describe.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>GroupId</code> - <code>string|array</code> - Optional -   Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>Filter</code> - <code>array</code> - Optional - A list of filters used to match properties for SecurityGroups. For a complete reference to the available filter keys for this operation, see the Amazon EC2 API reference. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>Name</code> - <code>string</code> - Optional - Specifies the name of the filter. </li>
	 * 			<li><code>Value</code> - <code>string|array</code> - Optional - Contains one or more values for the filter.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_security_groups($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['GroupName']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'GroupName' => (is_array($opt['GroupName']) ? $opt['GroupName'] : array($opt['GroupName']))
			)));
			unset($opt['GroupName']);
		}

		// Optional parameter
		if (isset($opt['GroupId']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'GroupId' => (is_array($opt['GroupId']) ? $opt['GroupId'] : array($opt['GroupId']))
			)));
			unset($opt['GroupId']);
		}

		// Optional parameter
		if (isset($opt['Filter']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Filter' => $opt['Filter']
			)));
			unset($opt['Filter']);
		}

		return $this->authenticate('DescribeSecurityGroups', $opt, $this->hostname);
	}

	/**
	 *
	 * Detaches a VPN gateway from a VPC. You do this if you're planning to turn off the VPC and not use it anymore. You can confirm a VPN gateway
	 * has been completely detached from a VPC by describing the VPN gateway (any attachments to the VPN gateway are also described).
	 *
	 * You must wait for the attachment's state to switch to detached before you can delete the VPC or attach a different VPC to the VPN gateway.
	 *
	 * @param string $vpn_gateway_id (Required) The ID of the VPN gateway to detach from the VPC.
	 * @param string $vpc_id (Required) The ID of the VPC to detach the VPN gateway from.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function detach_vpn_gateway($vpn_gateway_id, $vpc_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['VpnGatewayId'] = $vpn_gateway_id;
		$opt['VpcId'] = $vpc_id;

		return $this->authenticate('DetachVpnGateway', $opt, $this->hostname);
	}

	/**
	 *
	 * The DeregisterImage operation deregisters an AMI. Once deregistered, instances of the AMI can no longer be launched.
	 *
	 * @param string $image_id (Required) The ID of the AMI to deregister.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function deregister_image($image_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ImageId'] = $image_id;

		return $this->authenticate('DeregisterImage', $opt, $this->hostname);
	}

	/**
	 *
	 * Describes the data feed for Spot Instances.
	 *
	 * For conceptual information about Spot Instances, refer to the Amazon Elastic Compute Cloud Developer Guide or Amazon Elastic Compute Cloud
	 * User Guide.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_spot_datafeed_subscription($opt = null)
	{
		if (!$opt) $opt = array();

		return $this->authenticate('DescribeSpotDatafeedSubscription', $opt, $this->hostname);
	}

	/**
	 *
	 * Deletes tags from the specified Amazon EC2 resources.
	 *
	 * @param string|array $resource_id (Required) A list of one or more resource IDs. This could be the ID of an AMI, an instance, an EBS volume, or snapshot, etc.  Pass a string for a single value, or an indexed array for multiple values.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Tag</code> - <code>array</code> - Optional - The tags to delete from the specified resources. Each tag item consists of a key-value pair. If a tag is specified without a value, the tag and all of its values are deleted. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>Key</code> - <code>string</code> - Optional - The tag's key. </li>
	 * 			<li><code>Value</code> - <code>string</code> - Optional - The tag's value. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_tags($resource_id, $opt = null)
	{
		if (!$opt) $opt = array();

		// Required parameter
		$opt = array_merge($opt, CFComplexType::map(array(
			'ResourceId' => (is_array($resource_id) ? $resource_id : array($resource_id))
		)));

		// Optional parameter
		if (isset($opt['Tag']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Tag' => $opt['Tag']
			)));
			unset($opt['Tag']);
		}

		return $this->authenticate('DeleteTags', $opt, $this->hostname);
	}

	/**
	 *
	 * Deletes a subnet from a VPC. You must terminate all running instances in the subnet before deleting it, otherwise Amazon VPC returns an
	 * error.
	 *
	 * @param string $subnet_id (Required) The ID of the subnet you want to delete.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_subnet($subnet_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['SubnetId'] = $subnet_id;

		return $this->authenticate('DeleteSubnet', $opt, $this->hostname);
	}

	/**
	 *
	 * Creates a new VPN gateway. A VPN gateway is the VPC-side endpoint for your VPN connection. You can create a VPN gateway before creating the
	 * VPC itself.
	 *
	 * @param string $type (Required) The type of VPN connection this VPN gateway supports.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>AvailabilityZone</code> - <code>string</code> - Optional - The Availability Zone in which to create the VPN gateway. </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_vpn_gateway($type, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['Type'] = $type;

		return $this->authenticate('CreateVpnGateway', $opt, $this->hostname);
	}

	/**
	 *
	 * Deletes a VPN gateway. Use this when you want to delete a VPC and all its associated components because you no longer need them. We
	 * recommend that before you delete a VPN gateway, you detach it from the VPC and delete the VPN connection. Note that you don't need to delete
	 * the VPN gateway if you just want to delete and re-create the VPN connection between your VPC and data center.
	 *
	 * @param string $vpn_gateway_id (Required) The ID of the VPN gateway to delete.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_vpn_gateway($vpn_gateway_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['VpnGatewayId'] = $vpn_gateway_id;

		return $this->authenticate('DeleteVpnGateway', $opt, $this->hostname);
	}

	/**
	 *
	 * Attach a previously created volume to a running instance.
	 *
	 * @param string $volume_id (Required) The ID of the Amazon EBS volume. The volume and instance must be within the same Availability Zone and the instance must be running.
	 * @param string $instance_id (Required) The ID of the instance to which the volume attaches. The volume and instance must be within the same Availability Zone and the instance must be running.
	 * @param string $device (Required) Specifies how the device is exposed to the instance (e.g., <code>/dev/sdh</code>).
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function attach_volume($volume_id, $instance_id, $device, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['VolumeId'] = $volume_id;
		$opt['InstanceId'] = $instance_id;
		$opt['Device'] = $device;

		return $this->authenticate('AttachVolume', $opt, $this->hostname);
	}

	/**
	 *
	 * Provides details of a user's registered licenses. Zero or more IDs may be specified on the call. When one or more license IDs are
	 * specified, only data for the specified IDs are returned.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>LicenseId</code> - <code>string|array</code> - Optional - Specifies the license registration for which details are to be returned.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>Filter</code> - <code>array</code> - Optional - A list of filters used to match properties for Licenses. For a complete reference to the available filter keys for this operation, see the Amazon EC2 API reference. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>Name</code> - <code>string</code> - Optional - Specifies the name of the filter. </li>
	 * 			<li><code>Value</code> - <code>string|array</code> - Optional - Contains one or more values for the filter.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_licenses($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['LicenseId']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'LicenseId' => (is_array($opt['LicenseId']) ? $opt['LicenseId'] : array($opt['LicenseId']))
			)));
			unset($opt['LicenseId']);
		}

		// Optional parameter
		if (isset($opt['Filter']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Filter' => $opt['Filter']
			)));
			unset($opt['Filter']);
		}

		return $this->authenticate('DescribeLicenses', $opt, $this->hostname);
	}

	/**
	 *
	 * Activates a specific number of licenses for a 90-day period. Activations can be done against a specific license ID.
	 *
	 * @param string $license_id (Required) Specifies the ID for the specific license to activate against.
	 * @param integer $capacity (Required) Specifies the additional number of licenses to activate.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function activate_license($license_id, $capacity, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['LicenseId'] = $license_id;
		$opt['Capacity'] = $capacity;

		return $this->authenticate('ActivateLicense', $opt, $this->hostname);
	}

	/**
	 *
	 * The ResetImageAttribute operation resets an attribute of an AMI to its default value.
	 *
	 * The productCodes attribute cannot be reset.
	 *
	 * @param string $image_id (Required) The ID of the AMI whose attribute is being reset.
	 * @param string $attribute (Required) The name of the attribute being reset. Available attribute names: <code>launchPermission</code>
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function reset_image_attribute($image_id, $attribute, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['ImageId'] = $image_id;
		$opt['Attribute'] = $attribute;

		return $this->authenticate('ResetImageAttribute', $opt, $this->hostname);
	}

	/**
	 *
	 * Gives you information about your VPN connections.
	 *
	 * We strongly recommend you use HTTPS when calling this operation because the response contains sensitive cryptographic information for
	 * configuring your customer gateway.
	 *
	 * You can filter the results to return information only about VPN connections that match criteria you specify. For example, you could ask to
	 * get information about a particular VPN connection (or all) only if the VPN's state is pending or available. You can specify multiple filters
	 * (e.g., the VPN connection is associated with a particular VPN gateway, and the gateway's state is pending or available). The result includes
	 * information for a particular VPN connection only if the VPN connection matches all your filters. If there's no match, no special message is
	 * returned; the response is simply empty. The following table shows the available filters.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VpnConnectionId</code> - <code>string|array</code> - Optional - A VPN connection ID. More than one may be specified per request.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>Filter</code> - <code>array</code> - Optional - A list of filters used to match properties for VPN Connections. For a complete reference to the available filter keys for this operation, see the Amazon EC2 API reference. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>Name</code> - <code>string</code> - Optional - Specifies the name of the filter. </li>
	 * 			<li><code>Value</code> - <code>string|array</code> - Optional - Contains one or more values for the filter.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_vpn_connections($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['VpnConnectionId']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'VpnConnectionId' => (is_array($opt['VpnConnectionId']) ? $opt['VpnConnectionId'] : array($opt['VpnConnectionId']))
			)));
			unset($opt['VpnConnectionId']);
		}

		// Optional parameter
		if (isset($opt['Filter']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Filter' => $opt['Filter']
			)));
			unset($opt['Filter']);
		}

		return $this->authenticate('DescribeVpnConnections', $opt, $this->hostname);
	}

	/**
	 *
	 * Create a snapshot of the volume identified by volume ID. A volume does not have to be detached at the time the snapshot is taken.
	 *
	 * Snapshot creation requires that the system is in a consistent state. For instance, this means that if taking a snapshot of a database, the
	 * tables must be read-only locked to ensure that the snapshot will not contain a corrupted version of the database. Therefore, be careful when
	 * using this API to ensure that the system remains in the consistent state until the create snapshot status has returned.
	 *
	 * @param string $volume_id (Required) The ID of the volume from which to create the snapshot.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Description</code> - <code>string</code> - Optional - The description for the new snapshot. </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_snapshot($volume_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['VolumeId'] = $volume_id;

		return $this->authenticate('CreateSnapshot', $opt, $this->hostname);
	}

	/**
	 *
	 * Deletes a previously created volume. Once successfully deleted, a new volume can be created with the same name.
	 *
	 * @param string $volume_id (Required) The ID of the EBS volume to delete.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_volume($volume_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['VolumeId'] = $volume_id;

		return $this->authenticate('DeleteVolume', $opt, $this->hostname);
	}

	/**
	 *
	 * Gives you information about your VPCs. You can filter the results to return information only about VPCs that match criteria you specify.
	 *
	 * For example, you could ask to get information about a particular VPC or VPCs (or all your VPCs) only if the VPC's state is available. You
	 * can specify multiple filters (e.g., the VPC uses one of several sets of DHCP options, and the VPC's state is available). The result includes
	 * information for a particular VPC only if the VPC matches all your filters.
	 *
	 * If there's no match, no special message is returned; the response is simply empty. The following table shows the available filters.
	 *
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>VpcId</code> - <code>string|array</code> - Optional - The ID of a VPC you want information about.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 	<li><code>Filter</code> - <code>array</code> - Optional - A list of filters used to match properties for VPCs. For a complete reference to the available filter keys for this operation, see the Amazon EC2 API reference. <ul>
	 * 		<li><code>x</code> - <code>array</code> - This represents a simple array index. <ul>
	 * 			<li><code>Name</code> - <code>string</code> - Optional - Specifies the name of the filter. </li>
	 * 			<li><code>Value</code> - <code>string|array</code> - Optional - Contains one or more values for the filter.  Pass a string for a single value, or an indexed array for multiple values. </li>
	 * 		</ul></li>
	 * 	</ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function describe_vpcs($opt = null)
	{
		if (!$opt) $opt = array();

		// Optional parameter
		if (isset($opt['VpcId']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'VpcId' => (is_array($opt['VpcId']) ? $opt['VpcId'] : array($opt['VpcId']))
			)));
			unset($opt['VpcId']);
		}

		// Optional parameter
		if (isset($opt['Filter']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Filter' => $opt['Filter']
			)));
			unset($opt['Filter']);
		}

		return $this->authenticate('DescribeVpcs', $opt, $this->hostname);
	}

	/**
	 *
	 * Deactivates a specific number of licenses. Deactivations can be done against a specific license ID after they have persisted for at least a
	 * 90-day period.
	 *
	 * @param string $license_id (Required) Specifies the ID for the specific license to deactivate against.
	 * @param integer $capacity (Required) Specifies the amount of capacity to deactivate against the license.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function deactivate_license($license_id, $capacity, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['LicenseId'] = $license_id;
		$opt['Capacity'] = $capacity;

		return $this->authenticate('DeactivateLicense', $opt, $this->hostname);
	}

	/**
	 *
	 * The AssociateAddress operation associates an elastic IP address with an instance.
	 *
	 * If the IP address is currently assigned to another instance, the IP address is assigned to the new instance. This is an idempotent
	 * operation. If you enter it more than once, Amazon EC2 does not return an error.
	 *
	 * @param string $instance_id (Required) The instance to associate with the IP address.
	 * @param string $public_ip (Required) IP address that you are assigning to the instance.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>AllocationId</code> - <code>string</code> - Optional - The allocation ID that AWS returned when you allocated the elastic IP address for use with Amazon VPC. </li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function associate_address($instance_id, $public_ip, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['InstanceId'] = $instance_id;
		$opt['PublicIp'] = $public_ip;

		return $this->authenticate('AssociateAddress', $opt, $this->hostname);
	}

	/**
	 *
	 * Deletes a customer gateway. You must delete the VPN connection before deleting the customer gateway.
	 *
	 * You can have a single active customer gateway per AWS account (active means that you've created a VPN connection with that customer
	 * gateway). AWS might delete any customer gateway you leave inactive for an extended period of time.
	 *
	 * @param string $customer_gateway_id (Required) The ID of the customer gateway to delete.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function delete_customer_gateway($customer_gateway_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['CustomerGatewayId'] = $customer_gateway_id;

		return $this->authenticate('DeleteCustomerGateway', $opt, $this->hostname);
	}

	/**
	 *
	 * Creates an entry (i.e., rule) in a network ACL with a rule number you specify. Each network ACL has a set of numbered ingress rules and a
	 * separate set of numbered egress rules. When determining whether a packet should be allowed in or out of a subnet associated with the ACL,
	 * Amazon VPC processes the entries in the ACL according to the rule numbers, in ascending order.
	 *
	 * <b>Important: </b> We recommend that you leave room between the rules (e.g., 100, 110, 120, etc.), and not number them sequentially (101,
	 * 102, 103, etc.). This allows you to easily add a new rule between existing ones without having to renumber the rules.
	 *
	 * After you add an entry, you can't modify it; you must either replace it, or create a new entry and delete the old one.
	 *
	 * For more information about network ACLs, go to Network ACLs in the Amazon Virtual Private Cloud User Guide.
	 *
	 * @param string $network_acl_id (Required) ID of the ACL where the entry will be created.
	 * @param integer $rule_number (Required) Rule number to assign to the entry (e.g., 100). ACL entries are processed in ascending order by rule number.
	 * @param string $protocol (Required) IP protocol the rule applies to. Valid Values: <code>tcp</code>, <code>udp</code>, <code>icmp</code> or an IP protocol number.
	 * @param string $rule_action (Required) Whether to allow or deny traffic that matches the rule. [Allowed values: <code>allow</code>, <code>deny</code>]
	 * @param boolean $egress (Required) Whether this rule applies to egress traffic from the subnet (<code>true</code>) or ingress traffic to the subnet (<code>false</code>).
	 * @param string $cidr_block (Required) The CIDR range to allow or deny, in CIDR notation (e.g., <code>172.16.0.0/24</code>).
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>Icmp</code> - <code>array</code> - Optional -  ICMP values. <ul>
	 * 		<li><code>Type</code> - <code>integer</code> - Optional - For the ICMP protocol, the ICMP type. A value of <code>-1</code> is a wildcard meaning all types. Required if specifying <code>icmp</code> for the protocol. </li>
	 * 		<li><code>Code</code> - <code>integer</code> - Optional - For the ICMP protocol, the ICMP code. A value of <code>-1</code> is a wildcard meaning all codes. Required if specifying <code>icmp</code> for the protocol. </li></ul></li>
	 * 	<li><code>PortRange</code> - <code>array</code> - Optional -  Port ranges. <ul>
	 * 		<li><code>From</code> - <code>integer</code> - Optional - The first port in the range. Required if specifying <code>tcp</code> or <code>udp</code> for the protocol. </li>
	 * 		<li><code>To</code> - <code>integer</code> - Optional - The last port in the range. Required if specifying <code>tcp</code> or <code>udp</code> for the protocol. </li></ul></li>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_network_acl_entry($network_acl_id, $rule_number, $protocol, $rule_action, $egress, $cidr_block, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['NetworkAclId'] = $network_acl_id;
		$opt['RuleNumber'] = $rule_number;
		$opt['Protocol'] = $protocol;
		$opt['RuleAction'] = $rule_action;
		$opt['Egress'] = $egress;
		$opt['CidrBlock'] = $cidr_block;

		// Optional parameter
		if (isset($opt['Icmp']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'Icmp' => $opt['Icmp']
			)));
			unset($opt['Icmp']);
		}

		// Optional parameter
		if (isset($opt['PortRange']))
		{
			$opt = array_merge($opt, CFComplexType::map(array(
				'PortRange' => $opt['PortRange']
			)));
			unset($opt['PortRange']);
		}

		return $this->authenticate('CreateNetworkAclEntry', $opt, $this->hostname);
	}

	/**
	 *
	 * Detaches an Internet gateway from a VPC, disabling connectivity between the Internet and the VPC. The VPC must not contain any running
	 * instances with elastic IP addresses. For more information about your VPC and Internet gateway, go to Amazon Virtual Private Cloud User
	 * Guide.
	 *
	 * For more information about Amazon Virtual Private Cloud and Internet gateways, go to the Amazon Virtual Private Cloud User Guide.
	 *
	 * @param string $internet_gateway_id (Required) The ID of the Internet gateway to detach.
	 * @param string $vpc_id (Required) The ID of the VPC.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function detach_internet_gateway($internet_gateway_id, $vpc_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['InternetGatewayId'] = $internet_gateway_id;
		$opt['VpcId'] = $vpc_id;

		return $this->authenticate('DetachInternetGateway', $opt, $this->hostname);
	}

	/**
	 *
	 * Creates a new route table within a VPC. After you create a new route table, you can add routes and associate the table with a subnet. For
	 * more information about route tables, go to <a
	 * href="http://docs.amazonwebservices.com/AmazonVPC/latest/UserGuide/VPC_Route_Tables.html">Route Tables</a> in the Amazon Virtual Private
	 * Cloud User Guide.
	 *
	 * @param string $vpc_id (Required) The ID of the VPC where the route table will be created.
	 * @param array $opt (Optional) An associative array of parameters that can have the following keys: <ul>
	 * 	<li><code>curlopts</code> - <code>array</code> - Optional - A set of values to pass directly into <code>curl_setopt()</code>, where the key is a pre-defined <code>CURLOPT_*</code> constant.</li>
	 * 	<li><code>returnCurlHandle</code> - <code>boolean</code> - Optional - A private toggle specifying that the cURL handle be returned rather than actually completing the request. This toggle is useful for manually managed batch requests.</li></ul>
	 * @return CFResponse A <CFResponse> object containing a parsed HTTP response.
	 */
	public function create_route_table($vpc_id, $opt = null)
	{
		if (!$opt) $opt = array();
		$opt['VpcId'] = $vpc_id;

		return $this->authenticate('CreateRouteTable', $opt, $this->hostname);
	}

	/**
	 *
	 * Describes the status of the indicated volume or, in lieu of any specified, all volumes belonging to the caller. Volumes that have been
	 * deleted are not described.
	 *
	 * @param array $opt (Optional) An associative array of 