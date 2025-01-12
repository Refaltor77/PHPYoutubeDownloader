# YouTube Downloader Package

A PHP library for downloading YouTube videos and extracting metadata with ease.

## Installation

To use this package, you'll need the following prerequisites:

1. PHP 8.0 or higher
2. [youtube-dl](https://github.com/ytdl-org/youtube-dl) or [yt-dlp](https://github.com/yt-dlp/yt-dlp) installed and accessible from the command line.
3. [FFmpeg](https://ffmpeg.org/download.html) installed and accessible from the command line.

### Install the package via Composer

Run the following command to add the package to your project:

```BASH
composer require refaltor/youtube-downloader
```

---

## Getting Started

### Basic Usage

Below is an example of how to use the package to download a YouTube video:

````PHP
<?php

require 'vendor/autoload.php';

use Refaltor\YoutubeDownloader\Youtube;

try {
// Initialize the YouTube downloader
$downloader = new Youtube(
outputPath: '/absolute/path/to/store/videos/', // Directory to save the video
videoUrl: 'https://www.youtube.com/watch?v=example' // URL of the YouTube video
);

    // Start the download
    $downloadedFile = $downloader->download();

    echo "Video downloaded successfully: " . $downloadedFile;
} catch (Exception $e) {
echo "Error: " . $e->getMessage();
}
````

---

### Customizing Paths

You can customize the paths for `FFmpeg` and `youtube-dl` (or `yt-dlp`) during initialization:

````PHP
<?php

require 'vendor/autoload.php';

use Refaltor\YoutubeDownloader\Youtube;

try {
$downloader = new Youtube(
outputPath: '/absolute/path/to/store/videos/',
ffmpegPath: '/custom/path/to/ffmpeg',
youtubeDlPath: '/custom/path/to/youtube-dl'
);

    // Set the video URL dynamically
    $downloader->setVideoUrl('https://www.youtube.com/watch?v=example');
    
    $downloadedFile = $downloader->download();

    echo "Video downloaded successfully: " . $downloadedFile;
} catch (Exception $e) {
echo "Error: " . $e->getMessage();
}
````

---

## Exception Handling

The `download` method will throw an exception in the following cases:
- The video URL is not provided.
- The output directory is invalid or cannot be created.
- The download process fails.

Make sure to catch exceptions and handle errors appropriately:

````PHP
<?php

require 'vendor/autoload.php';

use Refaltor\YoutubeDownloader\Youtube;

try {
$downloader = new Youtube(
outputPath: '/absolute/path/to/store/videos/'
);

    $downloader->setVideoUrl('https://www.youtube.com/watch?v=example');
    $downloadedFile = $downloader->download();

    echo "Video downloaded successfully: " . $downloadedFile;
} catch (Exception $e) {
echo "Error: " . $e->getMessage();
}
````
