<?php
/*
 * This file is part of the MonstrumSymfonyJCrop.
 *
 * (c) Erwin Eu <eu.erwin@gmail.com>
 */
namespace Monstrum\SymfonyJCropBundle\Composer;

use Composer\Script\Event;
use Mopa\Bridge\Composer\Util\ComposerPathFinder;
use Monstrum\SymfonyJCropBundle\Command\SymfonyJCropSymlinkCommand;

/**
 * Script for Composer, create symlink to symfony-jcrop lib into the MonstrumSymfonyJCropBundle.
 */
class ScriptHandler
{
    public static function postInstallSymlinkSymfonyJCrop(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new ComposerPathFinder($composer);
        $options = array(
            'targetSuffix' => self::getTargetSuffix(),
            'sourcePrefix' => self::getSourcePrefix()
        );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
            SymfonyJCropSymlinkCommand::$monstrumSymfonyJCropBundleName,
            SymfonyJCropSymlinkCommand::$jcropName,
            $options
        );
        $symlinkTarget .= !empty(SymfonyJCropSymlinkCommand::$sourceSuffix) ? DIRECTORY_SEPARATOR . SymfonyJCropSymlinkCommand::$sourceSuffix : '';

        $IO->write("Checking Symlink", FALSE);
        if (false === SymfonyJCropSymlinkCommand::checkSymlink($symlinkTarget, $symlinkName, true)) {
            $IO->write("Creating Symlink: " . $symlinkName, FALSE);
            SymfonyJCropSymlinkCommand::createSymlink($symlinkTarget, $symlinkName);
        }
        $IO->write(" ... <info>OK</info>");
    }

    public static function postInstallMirrorSymfonyJCropBundle(Event $event)
    {
        $IO = $event->getIO();
        $composer = $event->getComposer();
        $cmanager = new ComposerPathFinder($composer);
        $options = array(
            'targetSuffix' =>  self::getTargetSuffix(),
            'sourcePrefix' => self::getSourcePrefix()
        );
        list($symlinkTarget, $symlinkName) = $cmanager->getSymlinkFromComposer(
            SymfonyJCropSymlinkCommand::$monstrumSymfonyJCropBundleName,
            SymfonyJCropSymlinkCommand::$jcropName,
            $options
        );
        $symlinkTarget .= !empty(SymfonyJCropSymlinkCommand::$sourceSuffix) ? DIRECTORY_SEPARATOR . SymfonyJCropSymlinkCommand::$sourceSuffix : '';

        $IO->write("Checking Mirror", FALSE);
        if (false === SymfonyJCropSymlinkCommand::checkSymlink($symlinkTarget, $symlinkName)) {
            $IO->write("Creating Mirror: " . $symlinkName, FALSE);
            SymfonyJCropSymlinkCommand::createMirror($symlinkTarget, $symlinkName);
        }
        $IO->write(" ... <info>OK</info>");
    }

    protected static function getTargetSuffix($end = "")
    {
        return DIRECTORY_SEPARATOR . "Resources" . DIRECTORY_SEPARATOR . "public" . $end;
    }

    protected static function getSourcePrefix($end = "")
    {
        return '..' . DIRECTORY_SEPARATOR . $end;
    }
}
