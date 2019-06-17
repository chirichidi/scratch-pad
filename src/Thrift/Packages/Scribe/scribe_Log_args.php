<?php

namespace Scribe;

use Thrift\Type\TType;

class scribe_Log_args {
	static $_TSPEC;

	public $messages = null;

	public function __construct($vals=null) {
		if (!isset(self::$_TSPEC)) {
			self::$_TSPEC = array(
				1 => array(
					'var' => 'messages',
					'type' => TType::LST,
					'etype' => TType::STRUCT,
					'elem' => array(
						'type' => TType::STRUCT,
						'class' => '\LogEntry',
					),
				),
			);
		}
		if (is_array($vals)) {
			if (isset($vals['messages'])) {
				$this->messages = $vals['messages'];
			}
		}
	}

	public function getName() {
		return 'scribe_Log_args';
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
					if ($ftype == TType::LST) {
						$this->messages = array();
						$_size0 = 0;
						$_etype3 = 0;
						$xfer += $input->readListBegin($_etype3, $_size0);
						for ($_i4 = 0; $_i4 < $_size0; ++$_i4)
						{
							$elem5 = null;
							$elem5 = new \LogEntry();
							$xfer += $elem5->read($input);
							$this->messages []= $elem5;
						}
						$xfer += $input->readListEnd();
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
		$xfer += $output->writeStructBegin('scribe_Log_args');
		if ($this->messages !== null) {
			if (!is_array($this->messages)) {
				throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
			}
			$xfer += $output->writeFieldBegin('messages', TType::LST, 1);
			{
				$output->writeListBegin(TType::STRUCT, count($this->messages));
				{
					foreach ($this->messages as $iter6)
					{
						$xfer += $iter6->write($output);
					}
				}
				$output->writeListEnd();
			}
			$xfer += $output->writeFieldEnd();
		}
		$xfer += $output->writeFieldStop();
		$xfer += $output->writeStructEnd();
		return $xfer;
	}

}