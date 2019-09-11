<?php

namespace app\Controllers;

class CommandSet
{
	private $trim;
	private $crop;
	private $resize;
	private $smart_crop = false;
	private $filters = [];
    private $metadataOnly = false;
    private $halign;
    private $valign;

	/**
	 *	Trim Image
	 */
	public function trim($colour_source=null, $tolerence=null) {
		$this->trim = 'trim';
		$this->trim .= $colour_source ? ":$colour_source" : '';
		$this->trim .= $tolerence ? ":$tolerence" : '';
	}

	/**
	 *	Manually crop specified window
	 */
	public function crop($top_left_X, $top_left_Y, $bottom_right_X, $bottom_right_Y) {
		$this->crop = "{$top_left_X}x{$top_left_Y}:{$bottom_right_X}x{$bottom_right_Y}";
	}

	public function fitIn($width, $height) {
		$this->resize = "fit-in/{$width}x{$height}";
	}

	public function fullFitIn($width, $height)
    {
    	$this->resize = "full-fit-in/{$width}x{$height}";
    }

    public function resize($width, $height)
    {
        $this->resize = "{$width}x{$height}";
    }

    public function smartCrop($smart_crop)
    {
        $this->smart_crop = $smart_crop;
    }

    public function addFilter(/*$filter, $args ...*/)
    {
        $args = func_get_args();
        $filter = array_shift($args);
        $this->filters []= sprintf('%s(%s)', $filter, implode(',', $args));
    }

    public function toArray()
    {
        $commands = array();
        $maybeAppend = function ($command) use (&$commands) {
            if ($command) $commands []= (string) $command;
        };
        if ($this->metadataOnly) {
            $commands []= 'meta';
        }
        $maybeAppend($this->trim);
        $maybeAppend($this->crop);
        $maybeAppend($this->resize);
        $maybeAppend($this->halign);
        $maybeAppend($this->valign);
        if ($this->smart_crop) {
            $commands []= 'smart';
        }
        if (count($this->filters)) {
            $filters = 'filters:' . implode(':', $this->filters);
            $commands []= $filters;
        }
        return $commands;
    }
}