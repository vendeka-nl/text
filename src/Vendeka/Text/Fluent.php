<?php
namespace Vendeka\Text;

class Fluent
{
	/** @var string */
    private $text;

    public function __construct ($text)
    {
        $this->text = $text;
    }

    public function __call (string $method, array $args)
    {
        array_unshift($args, $this->text);

        if (!method_exists(Text::class, $method))
        {
            throw new \BadMethodCallException('Method `' . $method . '` does not exist.');
        }

        $result = call_user_func_array([Text::class, $method], $args);
		
		if (!is_string($result)) 
		{
			return $result;
		}

		$this->text = $result;

		return $this;
    }

    public function __toString (): string
    {
        return $this->text;
    }
}