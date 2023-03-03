<?php

namespace Rbnb\System;

/**
 * Class Settings: Manages the settings from \settings.php
 *
 * @package Rbnb\System
 */
class Settings
{
	private static $instance = null;

	private $settings = [];

	public static function instance(): self
	{
		if( is_null( self::$instance ))
			self::$instance = new Settings();

		return self::$instance;
	}

	/**
	 * Gets the value for a given setting key from the settings file
	 *
	 * @param string $key
	 *
	 * @return string Found value or empty strings if key does not exist
	 */
	public function get( string $key ): string {
		if( array_key_exists( $key, $this->settings ) )
			return $this->settings[ $key ];

		return '';
	}

	private function __construct()
	{
		$this->settings = require ROOT_PATH . 'settings.php';
	}

	private function __clone() {}
	private function __wakeup() {}
}