<?php

namespace Refaltor\YoutubeDownloader;

use Exception;

class Youtube
{
    private ?string $ffmpegPath;
    private ?string $youtubeDlPath;
    private string $outputPath;
    private ?string $videoUrl;

    public function __construct(
        string $outputPath,
        ?string $videoUrl = null,
        ?string $ffmpegPath = null,
        ?string $youtubeDlPath = null
    )
    {
        $this->ffmpegPath = $ffmpegPath;
        $this->youtubeDlPath = $youtubeDlPath;
        $this->outputPath = $outputPath;
        $this->videoUrl = $videoUrl;
    }

    public function getFfmpegPath(): string
    {
        return $this->ffmpegPath ?? "/usr/bin/ffmpeg";
    }

    public function getYoutubeDlPath(): string
    {
        return $this->youtubeDlPath ?? "/usr/local/bin/youtube-dl";
    }

    public function getOutputPath(): string
    {
        return $this->outputPath;
    }

    public function getVideoUrl(): string
    {
        return $this->videoUrl;
    }

    public function setOutputPath(string $outputPath): void
    {
        $this->outputPath = $outputPath;
    }

    public function setFfmpegPath(?string $ffmpegPath): void
    {
        $this->ffmpegPath = $ffmpegPath;
    }

    public function setYoutubeDlPath(?string $youtubeDlPath): void
    {
        $this->youtubeDlPath = $youtubeDlPath;
    }

    /**
     * Function for download video with YouTube URL
     *
     * @throws Exception
     */
    public function download(?string $youtubeVideoUrl = null): string
    {
        $youtubeVideoUrl = $youtubeVideoUrl ?? $this->getVideoUrl();

        if (!$youtubeVideoUrl) {
            throw new Exception('Video url not provided. Make sure to pass youtube or facebook video url only');
        }


        if (!$this->getOutputPath()) {
            throw new Exception('Local path not set. Set local path using setOutputPath() function. Local path must be absolute where to store the downloaded file.');
        }

        $fileName = uniqid('YT-DOWNLOAD-') . '-' . time() . '.mp4';

        if (!is_dir($this->getOutputPath())) {
            if (!mkdir($this->getOutputPath(), 0777, true)) {
                throw new \Exception('Unable to create destination directory: '.$this->getOutputPath());
            }
            if (!chmod($this->getOutputPath(), 0777)) {
                throw new \Exception('File permission could not be changed to 0777: '.$this->getOutputPath());
            }
        }

        $fullPath = $this->getOutputPath() . $fileName;

        $command = $this->getYoutubeDlPath()." -f 'bestvideo[ext=mp4]+bestaudio[ext=m4a]/mp4' -o ".$fullPath.' '.$youtubeVideoUrl;
        $command .= ' --ffmpeg-location '.$this->getFfmpegPath();

        /**
         * Execute the command
         */
        $res_exec = exec($command, $outputCommand, $outputVariable);

        /**
         * Check command output
         */
        if ($outputVariable === 0) {

            if (is_file($fullPath)) {
                return $fullPath;
            } else {
                throw new Exception('Failed to download youtube video: '.$res_exec);
            }
        } else {
            throw new Exception('Failed to download youtube video: '.$res_exec);
        }
    }
}