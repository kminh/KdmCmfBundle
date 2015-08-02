<?php

/**
 * This file is part of the KdmCmfBundle package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Doctrine\Odm\Phpcr\Translation\TranslationStrategy;

use PHPCR\NodeInterface;

use Doctrine\ODM\PHPCR\Mapping\ClassMetadata;
use Doctrine\ODM\PHPCR\Translation\TranslationStrategy\AbstractTranslationStrategy;
use Doctrine\ODM\PHPCR\Translation\TranslationStrategy\TranslationNodesWarmer;

/**
 * @author Khang Minh
 */
class SubtreeTranslationStrategy extends AbstractTranslationStrategy implements TranslationNodesWarmer
{
    /**
     * {@inheritdoc}
     */
    public function saveTranslation(array $data, NodeInterface $node, ClassMetadata $metadata, $locale)
    {
        $translationNode = $this->getTranslationNode($node, $locale);
        parent::saveTranslation($data, $translationNode, $metadata, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function loadTranslation($document, NodeInterface $node, ClassMetadata $metadata, $locale)
    {
        $translationNode = $this->getTranslationNode($node, $locale, false);
        if (!$translationNode) {
            return false;
        }

        return parent::loadTranslation($document, $translationNode, $metadata, $locale);
    }

    /**
    * {@inheritdoc}
    */
    public function removeTranslation($document, NodeInterface $node, ClassMetadata $metadata, $locale)
    {
        $translationNode = $this->getTranslationNode($node, $locale);
        $translationNode->remove();
    }

    /**
    * {@inheritdoc}
    */
    public function removeAllTranslations($document, NodeInterface $node, ClassMetadata $metadata)
    {
        $locales = $this->getLocalesFor($document, $node, $metadata);
        foreach ($locales as $locale) {
            $this->removeTranslation($document, $node, $metadata, $locale);
        }
    }

    /**
    * {@inheritdoc}
    */
    public function getLocalesFor($document, NodeInterface $node, ClassMetadata $metadata)
    {
        $translations = $node->getNodes(Translation::LOCALE_NAMESPACE . ':*');
        $locales = array();
        foreach ($translations as $name => $node) {
            if ($p = strpos($name, ':')) {
                $locales[] = substr($name, $p+1);
            }
        }

        return $locales;
    }

    /**
     * Traverse the node tree starting from the current node to find a locale
     * path, such as "/en"
     *
     * @param NodeInterface $currentNode
     * @param string        $locale
     * @param boolean       $create whether to create the node if it is
     *                              not yet existing
     *
     * @return boolean|NodeInterface the node or false if $create is false and
     *      the node is not existing.
     */
    protected function getTranslationNode(NodeInterface $currentNode, $locale, $create = true)
    {
        try {
            $parentNode = $currentNode->getParent();

            // the parent node is a locale node
            if ($parentNode->getName() == $locale) {
                return $currentNode;
            }

            if (!$create) {
                return false;
            }

            // traverse up one level to add the locale node
            // @todo need to support multiple levels
            $parentNode->addNode($locale);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
    * {@inheritDoc}
    *
    * We namespace the property by putting it in a different node, the name
    * itself does not change.
    */
    public function getTranslatedPropertyName($locale, $fieldName)
    {
        return $fieldName;
    }

    /**
    * {@inheritDoc}
    *
    * We need to select the field on the joined child node.
    */
    public function getTranslatedPropertyPath($alias, $propertyName, $locale)
    {
        $childAlias = sprintf('_%s_%s', $locale, $alias);

        return array($childAlias, $this->getTranslatedPropertyName($locale, $propertyName));
    }

    /**
    * {@inheritDoc}
    *
    * Join document with translation children, and filter on the right child
    * node.
    */
    public function alterQueryForTranslation(
        QueryObjectModelFactoryInterface $qomf,
        SelectorInterface &$selector,
        ConstraintInterface &$constraint = null,
        $alias,
        $locale
    ) {
        $childAlias = "_{$locale}_{$alias}";

        $selector = $qomf->join(
            $selector,
            $qomf->selector($childAlias, 'nt:base'),
            QueryObjectModelConstantsInterface::JCR_JOIN_TYPE_RIGHT_OUTER,
            $qomf->childNodeJoinCondition($childAlias, $alias)
        );

        $languageConstraint = $qomf->comparison(
            $qomf->nodeName($childAlias),
            QueryObjectModelConstantsInterface::JCR_OPERATOR_EQUAL_TO,
            $qomf->literal(Translation::LOCALE_NAMESPACE . ":$locale")
        );

        if ($constraint) {
            $constraint = $qomf->andConstraint(
                $constraint,
                $languageConstraint
            );
        } else {
            $constraint = $languageConstraint;
        }
    }

    /**
    * {@inheritDoc}
    */
    public function getTranslationsForNodes($nodes, $locales, SessionInterface $session)
    {
        $absolutePaths = array();

        foreach ($locales as $locale) {
            foreach ($nodes as $node) {
                $absolutePaths[] = $node->getPath().'/'.Translation::LOCALE_NAMESPACE.':'.$locale;
            }
        }

        return $session->getNodes($absolutePaths);
    }
}
