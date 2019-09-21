<?php 

/**
 * File Handaling
 */
class File
{
	protected $filename;
	protected $newname;
	protected $path;
	protected $useabelType = array();
	protected $size;
	
	function __construct($oldname='',$path='',$newname='',$type='',$size='')
	{
		$this->newname = $newname;
		$this->filename = $oldname;
		$this-> path($path);
		$this->setType($type);
		$this->size($size);
	}

	public function path($path='')
	{
		if (substr($path,-1)=='/') {
			$this->path = $path;
		}
		$this->path = $path.'/';
		
	}

	public function file($oldname='')
	{
		$this->filename = $oldname;
	}

	public function name($newname='')
	{
		$this->newname = $newname;
	}
	public function size($size='')
	{
		$this->size = $size;
	}

	public function setType($type='')
	{
		if($type == '')
			return;
		if (is_array($type)) {
			$this->useabelType =  $type;
		}else{
			$this->useabelType[] =  $type;
		}
		
	}

	public function upload()
	{		
		try {
			$fileName=$_FILES[$this->filename]["name"];
			$file_tmp=$_FILES[$this->filename]["tmp_name"];
			$size=$_FILES[$this->filename]["size"];
			$exp = explode(".",$fileName);
			$type = end($exp);
			$type = strtolower($type);

			$newName= $this->newname == '' ? reset($exp).'.'.$type : $this->newname.'.'.$type;
			if ((sizeof($this->useabelType)==0 || in_array($type, $this->useabelType)) && ($this->size=='' || $size <= $this->size)) {
				$target_file = $this->path.$newName; 
				if (file_exists($target_file)) {
					return false;
				}
				if(move_uploaded_file($file_tmp, $target_file)){
					return true;
				}
			} 
			return false;
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}

	public function delete()
	{
		if (!file_exists($this->path.$this->filename)) {
			return false;
		}
		unlink($this->path.$this->filename);
		return true;
	}

	public function rename()
	{
		if(rename($this->path.$this->filename, $this->path.$this->newname))
			return true;
		return false;
	}
}
