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
     * @param bool $includeRootDir 是否在壓縮檔中包含根目錄
     * @return bool 壓縮是否成功
     */
    public function zipDirectory($sourcePath, $outputPath, $includeRootDir = false)
    {
        if ($this->zip->open($outputPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return false;
        }

        // 確保源路徑以目錄分隔符結尾
        $sourcePath = rtrim(str_replace('\\', '/', $sourcePath), '/') . '/';

        $rootDirName = '';
        if ($includeRootDir) {
            $rootDirName = basename($sourcePath);
            $this->zip->addEmptyDir($rootDirName);
        }

        $this->addFilesFromDirectory($sourcePath, $rootDirName);
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
        $iterator  = new \RecursiveIteratorIterator($directory, \RecursiveIteratorIterator::SELF_FIRST);

        $localPath = !empty($localPath) ? rtrim($localPath, '/') . '/' : '';

        foreach ($iterator as $file) {
            $filePath     = str_replace('\\', '/', $file->getRealPath());
            $relativePath = substr($filePath, strlen($sourcePath));

            if ($file->isDir()) {
                // 添加目錄
                $zipPath = $localPath . $relativePath;
                if (!empty($zipPath)) {
                    $this->zip->addEmptyDir($zipPath);
                }
            } else {
                // 添加檔案
                $this->zip->addFile($filePath, $localPath . $relativePath);
            }
        }
    }
}
