<?php

/*
 * This file is part of the PDF Version Converter.
 *
 * (c) Thiago Rodrigues <xthiago@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Xthiago\PDFVersionConverter\Converter;

use Symfony\Component\Process\Process;

/**
 * Encapsulates the knowledge about gs command.
 *
 * @author Thiago Rodrigues <xthiago@gmail.com>
 */
class GhostscriptConverterCommand
{
    /**
     * @var Filesystem
     */
    protected $baseCommand = ['gs', '-sDEVICE=pdfwrite', '-dCompatibilityLevel=%s', '-dPDFSETTINGS=/screen', '-dNOPAUSE', '-dQUIET', '-dBATCH', '-dColorConversionStrategy=/LeaveColorUnchanged', '-dEncodeColorImages=false', '-dEncodeGrayImages=false', '-dEncodeMonoImages=false', '-dDownsampleMonoImages=false', '-dDownsampleGrayImages=false', '-dDownsampleColorImages=false', '-dAutoFilterColorImages=false', '-dAutoFilterGrayImages=false', '-dColorImageFilter=/FlateEncode', '-dGrayImageFilter=/FlateEncode', '-sOutputFile=%s', '%s'];

    public function __construct()
    {
    }

    public function run($originalFile, $newFile, $newVersion)
    {
        $command = $this->baseCommand;
        $command[2] = sprintf($command[2], $newVersion);
        $command[18] = sprintf($command[18], $newFile);
        $command[19] = sprintf($command[19], $originalFile);
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
