<?php

/*
 * This file is part of Saft.
 *
 * (c) Konrad Abicht <hi@inspirito.de>
 * (c) Natanael Arndt <arndt@informatik.uni-leipzig.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Saft\Data;

use Saft\Rdf\StatementIterator;

/**
 * The Serializer interface describes what methods a RDF serializer should provide. An instance of Serialzer must
 * be initialized with a certain serialization. That means, that you have to create different instances of Serializer
 * for each serialization you need.
 *
 * @api
 *
 * @since 0.1
 */
interface Serializer
{
    /**
     * Set the prefixes which the serializer can/should use when generating the serialization.
     * Please keep in mind, that some serializations don't support prefixes at all or that some
     * implementations might ignore them.
     *
     * @param array $prefixes An associative array with a prefix mapping of the prefixes. The key
     *                        will be the prefix, while the values contains the according namespace URI.
     *
     * @api
     *
     * @since 0.1
     */
    public function setPrefixes(array $prefixes);

    /**
     * Transforms the statements of a StatementIterator instance into a stream, a file for instance.
     *
     * @param StatementIterator $statements   the StatementIterator containing all the Statements which
     *                                        should be serialized by the serializer
     * @param string|resource   $outputStream filename or file pointer to the stream to where the serialization
     *                                        should be written
     *
     * @throws \Exception if unknown format was given
     *
     * @api
     *
     * @since 0.1
     */
    public function serializeIteratorToStream(StatementIterator $statements, $outputStream);

    /**
     * Returns a list of all supported serialization types.
     *
     * @return array array of supported serialization types which can be used by this serializer
     *
     * @api
     *
     * @since 0.1
     */
    public function getSupportedSerializations();
}
