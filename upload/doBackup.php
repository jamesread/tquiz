#!/usr/bin/php
<?php 

require_once 'includes/common.php';

//set_time_limit(500);
$backupDirectory = './';

class Backup {
	public function __construct($backupDirectory) {
		$this->backupDirectory = $backupDirectory;
		$this->filename = $backupDirectory . 'backup.zip';

		$this->zip = new ZipArchive();
		$zipStatus = $this->zip->open($this->filename, ZipArchive::CREATE);

		if ($zipStatus !== true) {
		switch ($zipStatus) {
			case ZipArchive::ER_OPEN: 
				throw new Exception('Could not open Zip Archive, open() returned ' . $zipStatus);
				break;
			default:
				throw new Exception('Zip not opened (' . $this->filename . ') error code ' . $zipStatus);
		}}

		$this->assertt();
	}

	function isBackupDirectoryProtected($directory) {
		$htaccess = $directory . DIRECTORY_SEPARATOR . '.htaccess';

		if (!file_exists($htaccess)) {
			return false;	
		}

		if (strpos(file_get_contents($htaccess), 'Require valid-user') === FALSE) {
			return false;
		}

		return true;
	}

	private function assertIsWritable() {
		if (!is_writable($this->backupDirectory)) {
			throw new Exception('Directory not writable: ' . $this->backupDirectory);	
		}
	}

	public function assertt() {
		$this->assertIsWritable();
	}

	private function addDirectory($filename) {
		echo 'scanning dir ' . $filename . "\n";
		foreach (scandir($filename) as $file) {
			if ($file[0] == '.') {
				continue;
			}

			$fullPath = $filename . DIRECTORY_SEPARATOR . $file;

			if (is_dir($fullPath)) {
				echo 'dir: ' . $fullPath . "\n";
				$this->zip->addEmptyDir($fullPath);
				$this->addDirectory($fullPath);
			} else {
				$this->add($fullPath);
			}
		}
	}

	public function add($filename) {
		if (!file_exists($filename)) {
			throw new Exception('file does not exist: ' . $filename);
		}

		if (is_dir($filename)) {
			$this->addDirectory($filename);
		} else {
			echo 'file: ' . $filename . "\n";
			$this->zip->addFile($filename, $filename);
		}
	}

	public function close() {
		$this->zip->close();
	}
}

$backup = new Backup($backupDirectory);
$backup->add('doBackup.php');
$backup->add('resources/images/questions/');
$backup->close();
?>
