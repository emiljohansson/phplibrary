<?php

//not ready...
class JsonDocument extends Document implements DocumentInterface
{
	public final function assemble()
	{
		$head = array('status' => 1);
		$body = array('test' => 10);
		return json_encode(array('head' => $head, 'body' => $body));
	}
}