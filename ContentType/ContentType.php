<?php
abtract class ContentType
{
	protected $node = array();

	__contruct($csv)
	{
		$this->fromCsv($csv);
	}

	public function __get($key)
	{
		return $this->node[$key];
	}

	public function __set($key, $value)
	{
		$this->node[$key] = $value;
	}

	public function fromCsv($node)
	{
		# code...
	}
	public function toCsv($node)
	{
		# code...
	}
	public function fromDrupal($node)
	{
		# code...
	}
	public function toDrupal($node)
	{
		# code...
	}

}