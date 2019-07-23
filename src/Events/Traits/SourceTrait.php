<?php


namespace Tauceti\ExponeaApi\Events\Traits;


trait SourceTrait
{
    /**
     * @var string
     */
    protected $source = 'VPI';

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source)
    {
        $this->source = $source;
    }
}