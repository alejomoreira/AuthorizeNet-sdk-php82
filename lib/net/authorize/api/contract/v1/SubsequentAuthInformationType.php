<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing SubsequentAuthInformationType
 *
 *
 * XSD Type: subsequentAuthInformation
 */
class SubsequentAuthInformationType implements \JsonSerializable
{
    /**
     * @property string $originalNetworkTransId
     */
    private $originalNetworkTransId = null;

    /**
     * @property float $originalAuthAmount
     */
    private $originalAuthAmount = null;

    /**
     * @property string $reason
     */
    private $reason = null;

    /**
     * Gets as originalNetworkTransId
     *
     * @return string
     */
    public function getOriginalNetworkTransId()
    {
        return $this->originalNetworkTransId;
    }

    /**
     * Sets a new originalNetworkTransId
     *
     * @param string $originalNetworkTransId
     * @return self
     */
    public function setOriginalNetworkTransId($originalNetworkTransId)
    {
        $this->originalNetworkTransId = $originalNetworkTransId;
        return $this;
    }

    /**
     * Gets as originalAuthAmount
     *
     * @return float
     */
    public function getOriginalAuthAmount()
    {
        return $this->originalAuthAmount;
    }

    /**
     * Sets a new originalAuthAmount
     *
     * @param float $originalAuthAmount
     * @return self
     */
    public function setOriginalAuthAmount($originalAuthAmount)
    {
        $this->originalAuthAmount = $originalAuthAmount;
        return $this;
    }

    /**
     * Gets as reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Sets a new reason
     *
     * @param string $reason
     * @return self
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
        return $this;
    }


    // Json Serialize Code
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $values = array_filter(
            (array)get_object_vars($this),
            function ($val) {
                return !is_null($val);
            }
        );
        $mapper = \net\authorize\util\Mapper::Instance();
        foreach($values as $key => $value) {
            $classDetails = $mapper->getClass(get_class(), $key);
            if (isset($value)) {
                if ($classDetails->className === 'Date') {
                    $dateTime = $value->format('Y-m-d');
                    $values[$key] = $dateTime;
                } elseif ($classDetails->className === 'DateTime') {
                    $dateTime = $value->format('Y-m-d\TH:i:s\Z');
                    $values[$key] = $dateTime;
                }
                if (is_array($value)) {
                    if (!$classDetails->isInlineArray) {
                        $subKey = $classDetails->arrayEntryname;
                        $subArray = [$subKey => $value];
                        $values[$key] = $subArray;
                    }
                }
            }
        }
        return $values;
    }

    // Json Set Code
    public function set($data)
    {
        if(is_array($data) || is_object($data)) {
            $mapper = \net\authorize\util\Mapper::Instance();
            foreach($data as $key => $value) {
                $classDetails = $mapper->getClass(get_class(), $key);

                if($classDetails !== null) {
                    if ($classDetails->isArray) {
                        if ($classDetails->isCustomDefined) {
                            foreach($value as $keyChild => $valueChild) {
                                $type = new $classDetails->className();
                                $type->set($valueChild);
                                $this->{'addTo' . $key}($type);
                            }
                        } elseif ($classDetails->className === 'DateTime' || $classDetails->className === 'Date') {
                            foreach($value as $keyChild => $valueChild) {
                                $type = new \DateTime($valueChild);
                                $this->{'addTo' . $key}($type);
                            }
                        } else {
                            foreach($value as $keyChild => $valueChild) {
                                $this->{'addTo' . $key}($valueChild);
                            }
                        }
                    } else {
                        if ($classDetails->isCustomDefined) {
                            $type = new $classDetails->className();
                            $type->set($value);
                            $this->{'set' . $key}($type);
                        } elseif ($classDetails->className === 'DateTime' || $classDetails->className === 'Date') {
                            $type = new \DateTime($value);
                            $this->{'set' . $key}($type);
                        } else {
                            $this->{'set' . $key}($value);
                        }
                    }
                }
            }
        }
    }

}
