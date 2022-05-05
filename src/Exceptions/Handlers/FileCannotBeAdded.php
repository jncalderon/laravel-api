<?php
namespace Jncalderon\LaravelApi\Exceptions\Handlers;

use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\Helpers\File;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\RequestDoesNotHaveFile;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileUnacceptableForCollection;

class FileCannotBeAdded
{
    // public function __invoke(\Spatie\MediaLibrary\Exceptions\FileCannotBeAdded $exception): ?JsonResponse
    // {
    //     if ($exception instanceof FileIsTooBig) {
    //         $maxFileSize = File::getHumanReadableSize(config('medialibrary.max_file_size'));
    //         return response()->json(['error' => "File is greater than the maximum allowed {$maxFileSize}"], 413);
    //     }
    //     if ($exception instanceof RequestDoesNotHaveFile) {
    //         $maxFileSize = File::getHumanReadableSize(config('medialibrary.max_file_size'));
    //         return response()->json(['error' => "Please upload file less than {$maxFileSize}"], 413);
    //     }
    //     if ($exception instanceof FileUnacceptableForCollection) {
    //         $maxFileSize = File::getHumanReadableSize(config('medialibrary.max_file_size'));
    //         return response()->json(['error' => "Please upload file less than {$maxFileSize}"], 413);
    //     }
    //     if ($exception instanceof FileUnacceptableForCollection) {
    //         return response()->json(['error' => 'The file format is not allowed'], 415);
    //     }
    //     return null;
    // }
}