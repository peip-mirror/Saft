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

namespace Saft\Rdf;

class StatementImpl extends AbstractStatement
{
    /**
     * @var Node
     */
    protected $subject;

    /**
     * @var Node
     */
    protected $predicate;

    /**
     * @var Node
     */
    protected $object;

    /**
     * @var Node
     */
    protected $graph;

    /**
     * Constructor.
     *
     * @param Node $subject
     * @param Node $predicate
     * @param Node $object
     * @param Node $graph
     */
    public function __construct(Node $subject, Node $predicate, Node $object, Node $graph = null)
    {
        $this->subject = $subject;
        $this->predicate = $predicate;
        $this->object = $object;

        if (null !== $graph) {
            $this->graph = $graph;
        }
    }

    /**
     * @return NamedNode
     */
    public function getGraph()
    {
        return $this->graph;
    }

    /**
     * @return NamedNode|BlankNode
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return NamedNode
     */
    public function getPredicate()
    {
        return $this->predicate;
    }

    /**
     * @return Node
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return bool
     */
    public function isQuad()
    {
        return null !== $this->graph;
    }

    /**
     * @return bool
     */
    public function isTriple()
    {
        return null === $this->graph;
    }
}
