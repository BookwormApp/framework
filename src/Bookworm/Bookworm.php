<?php

namespace Bookworm;

class Bookworm {

	const VERSION = '0.1.0';

	protected $basePath;

	public function __construct($basePath)
	{
		$this->basePath = $basePath;
	}

	public function version()
	{
		return static::VERSION;
	}

	public function basePath()
	{
		return $this->basePath;
	}

}