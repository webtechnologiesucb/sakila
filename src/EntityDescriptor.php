<?php

/**
 * Entity Descriptor for SAML2 Provider
 * Copyright (c) SakilaSoft. All rights reserved.
 */

namespace PHPMaker2024\Sakila;

use LightSaml\Model\Metadata\EntityDescriptor as BaseEntityDescriptor;
use LightSaml\Model\Context\DeserializationContext;

class EntityDescriptor extends BaseEntityDescriptor
{
    /**
     * @param string $filename
     *
     * @return EntityDescriptor
     */
    public static function load($filename)
    {
        $options = [
            "ssl" =>
                [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ],
        ];
        return static::loadXml(file_get_contents($filename, false, stream_context_create($options)));
    }

    /**
     * @param string $xml
     *
     * @return EntityDescriptor
     */
    public static function loadXml($xml)
    {
        $context = new DeserializationContext();
        $context->getDocument()->loadXML($xml);
        $ed = new static();
        $ed->deserialize($context->getDocument(), $context);
        return $ed;
    }
}
