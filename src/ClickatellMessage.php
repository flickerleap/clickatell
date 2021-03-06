<?php

namespace FlickerLeap\Clickatell;

class ClickatellMessage
{
    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $to;

    /**
     * ClickatellMessage constructor.
     *
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * @param string $content
     *
     * @return \FlickerLeap\Clickatell\ClickatellMessage
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * @param $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param $to
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }
}
