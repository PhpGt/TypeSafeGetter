<?php
namespace Gt\TypeSafeGetter;

use DateTimeImmutable;
use DateTimeInterface;
use TypeError;

/** @method mixed get(string $name) */
trait NullableTypeSafeGetter {
	public function getString(string $name):?string {
		return $this->getNullableType($name, "string");
	}

	public function getInt(string $name):?int {
		return $this->getNullableType($name, "int");
	}

	public function getFloat(string $name):?float {
		return $this->getNullableType($name, "float");
	}

	public function getBool(string $name):?bool {
		return $this->getNullableType($name, "bool");
	}

	public function getDateTime(string $name):?DateTimeInterface {
		return $this->getNullableType(
			$name,
			function(string|int|float|DateTimeInterface $value) {
				if($value instanceof DateTimeInterface) {
					return $value;
				}

				if(is_numeric($value)) {
					return new DateTimeImmutable("@$value");
				}

				return new DateTimeImmutable($value);
			}
		);
	}

	public function getInstance(string $name, string $className) {
		return $this->getNullableType(
			$name,
			$className,
		);
	}

	protected function getNullableType(
		string $name,
		string|callable $type,
	):mixed {
		$value = $this->get($name);

		if(is_null($value)) {
			return null;
		}

		switch($type) {
		case "string":
			return (string)$value;

		case "int":
			return (int)$value;

		case "float":
			return (float)$value;

		case "bool":
			return (bool)$value;
		}

		if(is_callable($type)) {
			return call_user_func($type, $value);
		}

		if(class_exists($type) || interface_exists($type)) {
			$this->checkType($value, $type);
			return $value;
		}

		return null;
	}

	protected function checkType(mixed $value, string $type):void {
		$actualType = get_class($value);
		if($actualType !== $type && !is_a($actualType, $type, true)) {
			throw new TypeError(
				"Session value must be of type $type, "
				. "$actualType returned"
			);
		}
	}
}
