<?php

/**
 * This file is part of Bldr.io
 *
 * (c) Aaron Scherer <aequasi@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE
 */

namespace Bldr\Block\Filesystem;

use Bldr\DependencyInjection\AbstractBlock;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class FilesystemBlock extends AbstractBlock
{
    /**
     * {@inheritDoc}
     */
    public function assemble(array $config, ContainerBuilder $container)
    {
        $container->setDefinition(
            'bldr_filesystem.abstract',
            new Definition('Bldr\Block\Filesystem\Call\FilesystemCall')
        )
            ->setAbstract(true);

        $calls = [
            'bldr_filesystem.remove' => 'RemoveCall',
            'bldr_filesystem.mkdir' => 'MkdirCall',
            'bldr_filesystem.touch' => 'TouchCall',
            'bldr_filesystem.dump' => 'DumpCall'
        ];

        foreach ($calls as $id => $class) {
            $container->setDefinition($id, new DefinitionDecorator('bldr_filesystem.abstract'))
                ->setClass('Bldr\Block\Filesystem\Call\\'.$class)
                ->addTag('bldr');
        }
    }
}
