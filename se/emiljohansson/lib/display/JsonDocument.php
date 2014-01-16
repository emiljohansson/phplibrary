<?php

//not ready...
class JsonDocument extends Document implements DocumentInterface
{
	public final function assemble()
	{
		/*
		if ($format === 'json') {
			/*$result = array();
			$parser = new JSONParser();
			$parser->domNodes($html, $result);
			console::log(json_encode($result));
			return;*/

			#not implemented yet...
		//}
		return $this->document->saveHTML();
	}
}