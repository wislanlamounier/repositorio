<?php
class Colecao extends ArrayObject {

    public  $empty = true;
	
    public function __construct($array = array()) {
        $this->fromArray($array);
        $this->empty = 0 == count($this);
    }

    public function fromArray(array $values) {
        foreach ($values as $index => $value) {
            if (is_array($value))
                $value = new self($value);

            $this->offsetSet($index, $value);
        }
    }

    public function exchangeArray($input) {
        $return = $this->getArrayCopy();
        $this->fromArray((array) $input);

        return $return;
    }

    public function offsetUnset($index) {
        if ($this->offsetExists($index))
            return parent::offsetUnset($index);
    }

    public function remove($index) {
        $this->offsetUnset($index);
        return $this;
    }

    public function getArrayCopy() {
        return parent::getArrayCopy();
    }

    public function offsetGet($index) {
        if ($this->offsetExists($index))
            return parent::offsetGet($index);

        return null;
    }
	
    public function __set($name, $value) {
        return $this->offsetSet($name, $value);
    }
	
    public function __get($name) {
        return $this->offsetGet($name);
    }

    public function first() {
        if ($this->count() <= 0) {
            return null;
        } else {
            foreach ($this as $item)
                break;

            return $item;
        }
    }

    public function possuiItens() {
        return (boolean) count($this);
    }

    public function toJson()
    {
        return json_encode($this);
    }

    public function trimItens()
    {
    	foreach ($this as $key => $value) {
    		$this->offsetSet($key, trim($value));
    	}
    }
}
