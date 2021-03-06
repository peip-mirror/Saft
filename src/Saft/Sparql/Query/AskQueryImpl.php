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

namespace Saft\Sparql\Query;

use Saft\Rdf\RdfHelpers;

/**
 * Represents an ASK query.
 */
class AskQueryImpl extends AbstractQuery
{
    /**
     * Constructor.
     *
     * @param string     optional $query SPARQL query string to initialize this instance
     *
     * @throws \Exception if no where part was found in query
     */
    public function __construct($query = '', RdfHelpers $rdfHelpers)
    {
        parent::__construct($query, $rdfHelpers);

        if (null !== $this->query) {
            /*
             * Set where part
             */
            $result = preg_match('/\{(.*)\}/s', $query, $match);
            if (false !== $result && true === isset($match[1])) {
                $this->queryParts['where'] = trim($match[1]);
            } else {
                throw new \Exception('No where part found in query: '.$query);
            }
        }
    }

    /**
     * Return parts of the query on which this instance based on.
     *
     * @return array $queryParts query parts; parts which have no elements will be unset
     */
    public function getQueryParts()
    {
        // remove prefix information from query to be able to simply use extractGraphs on query string.
        $prefixlessQuery = preg_replace(
            '/PREFIX\s+([a-z0-9]+)\:\s*\<([a-z0-9\:\/\.\#\-]+)\>/',
            '',
            $this->getQuery()
        );

        $this->queryParts['filter_pattern'] = $this->extractFilterPattern($this->queryParts['where']);
        $this->queryParts['graphs'] = $this->extractGraphs($prefixlessQuery);
        $this->queryParts['namespaces'] = $this->extractNamespacesFromQuery($this->queryParts['where']);
        $this->queryParts['prefixes'] = $this->extractPrefixesFromQuery($this->getQuery());
        $this->queryParts['quad_pattern'] = $this->extractQuads($this->queryParts['where']);
        $this->queryParts['triple_pattern'] = $this->extractTriplePattern($this->queryParts['where']);
        $this->queryParts['variables'] = $this->extractVariablesFromQuery($this->getQuery());

        $this->unsetEmptyValues($this->queryParts);

        return $this->queryParts;
    }

    /**
     * Represents it an ASK query?
     *
     * @return bool True
     */
    public function isAskQuery()
    {
        return true;
    }

    /**
     * Represents it a CONSTRUCT query?
     *
     * @return bool False
     */
    public function isConstructQuery()
    {
        return false;
    }

    /**
     * Represents it a Describe Query?
     *
     * @return bool False
     */
    public function isDescribeQuery()
    {
        return false;
    }

    /**
     * Represents it a Graph Query?
     *
     * @return bool False
     */
    public function isGraphQuery()
    {
        return false;
    }

    /**
     * Represents it a Select Query?
     *
     * @return bool False
     */
    public function isSelectQuery()
    {
        return false;
    }

    /**
     * Represents it an Update Query?
     *
     * @return bool False
     */
    public function isUpdateQuery()
    {
        return false;
    }

    public function __toString()
    {
        $prefixes = '';
        foreach ($this->queryParts['prefixes'] as $prefix => $uri) {
            $prefixes .= 'PREFIX '.$prefix.': <'.$uri.'> ';
        }

        $graphUris = '';
        foreach ($this->queryParts['graphs'] as $graphUri) {
            $graphUris .= ' FROM <'.$graphUri.'> ';
        }

        $query = $prefixes.' ASK '.$graphUris.' { '.$this->queryParts['where'].' }';

        return $query;
    }
}
