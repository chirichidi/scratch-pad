<?php

namespace Scribe;

use Thrift\Type\TType;

class LogEntry {
	static $_TSPEC;

	public $category = null;
	public $message = null;

	public function __construct($vals=null) {
		if (!isset(self::$_TSPEC)) {
			self::$_TSPEC = array(
				1 => array(
					'var' => 'category',
					'type' => TType::STRING,
				),
				2 => array(
					'var' => 'message',
					'type' => TType::STRING,
				),
			);
		}
		if (is_array($vals)) {
			if (isset($vals['category'])) {
				$this->category = $vals['category'];
			}
			if (isset($vals['message'])) {
				$this->message = $vals['message'];
			}
		}
	}

	public function getName() {
		return 'LogEntry';
	}

	public function read($input)
	{
		$xfer = 0;
		$fname = null;
		$ftype = 0;
		$fid = 0;
		$xfer += $input->readStructBegin($fname);
		while (true)
		{
			$xfer += $input->readFieldBegin($fname, $ftype, $fid);
			if ($ftype == TType::STOP) {
				break;
			}
			switch ($fid)
			{
				case 1:
					if ($ftype == TType::STRING) {
						$xfer += $input->readString($this->category);
					} else {
						$xfer += $input->skip($ftype);
					}
					break;
				case 2:
					if ($ftype == TType::STRING) {
						$xfer += $input->readString($this->message);
					} else {
						$xfer += $input->skip($ftype);
					}
					break;
				default:
					$xfer += $input->skip($ftype);
					break;
			}
			$xfer += $input->readFieldEnd();
		}
		$xfer += $input->readStructEnd();
		return $xfer;
	}

	public function write($output) {
		$xfer = 0;
		$xfer += $output->writeStructBegin('LogEntry');
		if ($this->category !== null) {
			$xfer += $output->writeFieldBegin('category', TType::STRING, 1);
			$xfer += $output->writeString($this->category);
			$xfer += $output->writeFieldEnd();
		}
		if ($this->message !== null) {
			$xfer += $output->writeFieldBegin('message', TType::STRING, 2);
			$xfer += $output->writeString($this->message);
			$xfer += $output->writeFieldEnd();
		}
		$xfer += $output->writeFieldStop();
		$xfer += $output->writeStructEnd();
		return $xfer;
	}

}
