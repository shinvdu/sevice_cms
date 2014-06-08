<?php
abtract class ContentType
{
	protected $node = array();

	__contruct($yaml, $csv)
	{
		$this->loadFields($yaml);
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