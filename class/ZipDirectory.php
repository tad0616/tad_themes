<?php
namespace XoopsModules\Tad_themes;

class ZipDirectory
{
    private $zip;

    public function __construct()
    {
        $this->zip = new \ZipArchive();
    }

    /**
     * 壓縮指定目錄
     *
     * @param string $sourcePath 要壓縮的目錄路徑
     * @param string $outputPath 輸出的 ZIP 檔案路徑
     * @return bool 壓縮是否成功
     */
    public function zipDirectory($sourcePath, $outputPath)
    {
        if ($this->zip->open($outputPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return false;
        }

        $this->addFilesFromDirectory($sourcePath);
        $this->zip->close();

        return true;
    }

    /**
     * 遞迴添加目錄中的所有檔案到 ZIP 檔案
     *
     * @param string $sourcePath 要添加的目錄路徑
     * @param string $localPath 相對於 ZIP 檔案的本地路徑
     */
    private function addFilesFromDirectory($sourcePath, $localPath = '')
    {
        $directory = new \RecursiveDirectoryIterator($sourcePath, \RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator  = new \RecursiveIteratorIterator($directory);

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $filePath     = $file->getRealPath();
                $relativePath = substr($filePath, strlen($sourcePath) + 1);
                $this->zip->addFile($filePath, $localPath . $relativePath);
            } elseif ($file->isDir()) {
                $this->zip->addEmptyDir($localPath . $file->getFilename() . '/');
                $this->addFilesFromDirectory($file->getRealPath(), $localPath . $file->getFilename() . '/');
            }
        }
    }
}
