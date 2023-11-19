<?php

class PressEngine
{
	public $dtoObjects = array();
	public $contentString;
	protected $superTemplates = array(array());
	public $templatesDir='';
	
	public function __construct( $templates = NULL, $dtoClass = NULL, $templatesDir=NULL )
	{
		if(!empty($templatesDir))
		{
			$this->templatesDir=$templatesDir;
		}
		
		if(!empty($dtoClass))
		{
			$this->assignDTO($dtoClass);
		}
		
		if(!empty($templates))
		{
			ob_start();
			$this->renderTemplate($templates);
			$this->contentString = ob_get_contents();
			ob_end_clean();
		}
	}
	
	public function renderTemplate($__templates)
	{
		if(!empty($__templates))
		{
			if(is_string($__templates))
			{
				$__templates=array($__templates);
			}
			
			if(is_array($__templates))
			{
				$__renderedSomething = FALSE;
				foreach ($__templates as $__template)
				{
					$file_name = $this->templatesDir.$__template;
					$includeResult = FALSE;
					if (is_readable($file_name))
					{
						$includeResult = include $file_name;
					}
					
					if ($includeResult === FALSE)
					{
						throw new Exception('Unable to render '.$file_name.' template',404);
					}
					else
					{
						$__renderedSomething = TRUE;
					}
				}
				
				if(!$__renderedSomething)
				{
					throw new Exception('No templates were found, unable to run engine for ('.join(',', $__templates).') in '.$this->templatesDir,500);
				}
			}
			
		}
	}
	
	public function assignDTO($DTO = NULL)
	{
		if(!empty($DTO) &&  !isset($DTO))
		{
			return FALSE;
		}
		
		if (is_array($DTO))
		{
			foreach ($DTO as $key => $val)
			{
				$this->dtoObjects[]=$key;
				$this->$key = $val;
			}
			return TRUE;
		}
		
		if (is_object($DTO))
		{
			foreach (get_object_vars($DTO) as $key => $val)
			{
				$this->dtoObjects[]=$key;
				$this->$key = $val;
			}
			return TRUE;
		}
	}
	
	protected function unAssignDTO()
	{
		if(!empty($this->dtoObjects))
		{
			foreach ($this->dtoObjects as $key)
			{
				$this->$key=NULL;
				unset($this->$key);
			}
		}
	}
	
	public function startSuperTemplate($__templates)
	{
		$this->superTemplates[]=array('src'=>$__templates,'content'=>'');
		ob_start();
	}
	
	public function endSuperTemplate()
	{
		$currentSuperTemplateIndex = count($this->superTemplates)-1;
		$this->superTemplates[$currentSuperTemplateIndex]['content']=ob_get_contents();
		ob_end_clean();
		$this->renderTemplate($this->superTemplates[$currentSuperTemplateIndex]['src']);
		array_pop($this->superTemplates);
	}
	
	public function insertSubTemplateContent()
	{
		echo $this->superTemplates[count($this->superTemplates)-1]['content'];
	}
}

?>