<?php
class XErrors
{
	private $message  = NULL;		/* Il messaggio ritornato dall'XML o dalle API */
	private $error	  = false;		/* True se durante l'ultima operazione si è verificato un errore */
	
	public function NoErrors()
	{
		return $error;	
	}
	
	public function GetErrorMsg()
	{
		if ($error == false) {
			echo "[Xfire-PHP]: No error.";
		}
		else
		{
			echo "[Xfire-PHP]: " . $message;	
		}
	}
	
	protected function SetError($message)
	{
		$this->message = $message;
		$error = true;
	}
	
	protected function ResetError()
	{
		$error = false;
		$message = NULL;
	}
}
?>