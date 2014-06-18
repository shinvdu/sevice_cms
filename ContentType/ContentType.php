<?php
abstract class ContentType
{
	protected $node = array();
	
	function __construct($yaml, $csv){
		$this->loadFields($yaml);
		$this->fromCsv($csv);
	}

	public function __get($key)
	{
		if (array_key_exists($key, $this->node)) {
			return $this->node[$key];
		} else {
			return null;
		}
	}

	public function __set($key, $value)
	{
		if (array_key_exists($key, $this->node)) {
		    $this->node[$key] = $value;
		 }
	}

	public function loadFields($yaml)
	{
		$fields = yaml_parse_file($yaml);

		foreach ($fields as $field) {
			$this->node[$field] = NULL;
		}
	}

	public function fromCsv($node)
	{
		foreach ($node as $field) {
			foreach ($this->node as $key  => $value) {
				$this->node[$key] = $field;
			}
		}
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