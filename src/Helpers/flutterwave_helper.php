<?php

	if (!function_exists('generateDeviceFingerprint'))
	{
		/**
		 * @return string
		 */
		function generateDeviceFingerprint()
		: string
		{
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
			$ipAddress = $_SERVER['REMOTE_ADDR'];
			$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
			$screenResolution = $_SERVER['HTTP_USER_AGENT'];

			$combinedString = $userAgent . $ipAddress . $language . $screenResolution;

			$fingerprint = md5($combinedString);

			return $fingerprint;
		}
	}