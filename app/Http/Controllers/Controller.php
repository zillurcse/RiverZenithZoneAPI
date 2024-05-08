<?php

namespace App\Http\Controllers;

use App\ApiResponseClass;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

abstract class Controller
{
    public function helper(): ApiResponseClass
    {
        return new ApiResponseClass();
    }

    /**
     * @param array | $options = [
     *                   'model' => $model, (required:object)
     *                   'request_type' => file_upload, (optional:file_upload,base64,url)
     *                   'collection_name' => false, (optional:string)
     *                   'file' => '', (required:file|array of file)
     *                        'multi_upload' => false, (optional:boolean)
     *                   'mime_type' => false, (optional:boolean)
     *                 ]
     * @return array
     */
    function fileUpload($options = [])
    {

        try {
            if (!key_exists('model', $options)) {
                throw new ('please model provide ');
            }
            if (!key_exists('file', $options)) {
                throw new ('file key needed');
            }
            if (key_exists('request_type', $options) && !is_string($options['request_type'])) {
                throw new ('request_type must be string ');
            }
            if (key_exists('collection_name', $options) && !is_string($options['collection_name'])) {
                throw new ('collection_name must be string ');
            }
            if (key_exists('mime_type', $options) && !is_array($options['mime_type'])) {
                throw new ('mime_type must be array ');
            }
            if (key_exists('multi_upload', $options) && !is_bool($options['multi_upload'])) {
                throw new ('multi_upload type must be boolean ');
            }
            if (!key_exists('request_type', $options)) {
                $options['request_type'] = 'file_upload';
            }
            if (!key_exists('multi_upload', $options)) {
                $options['multi_upload'] = false;
            }
            if (!key_exists('collection_name', $options)) {
                $options['collection_name'] = false;
            }
            if (!key_exists('order_column', (array)$options))
                $options['order_column'] = -1;

            if (!key_exists('mime_type', $options)) {
                $options['mime_type'] = null;
            }

            $options = (object)$options;

            $uploaded = null;
            if ($options->multi_upload) {
                if (is_array($options->file)) {
                    foreach ($options->file as $file) {
                        $uploaded = $this->conditionWiseMedeaUpload($options, $file);
                    }
                }
            } else if (!is_array($options->file)) {
                $uploaded = $this->conditionWiseMedeaUpload($options, $options->file);
            } else if (is_array($options->file)) {
                foreach ($options->file as $file) {
                    $uploaded = $this->conditionWiseMedeaUpload($options, $file);
                }
            }
            return $uploaded;
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage()
            ];
        }
    }


    /**
     * @param $options
     * @param $file
     * @return void
     */
    function conditionWiseMedeaUpload($options, $file)
    {
        $upload = null;
        if ($options->request_type == 'file_upload') {
            if (!$options->mime_type) {
                $upload = $options->model->addMedia($file);
            } else {
                $upload = $options->model->addMedia($file, $options->mime_type);
            }

        } else if ($options->request_type == 'base64') {
            $file = trim($file);
            $extension = explode('/', mime_content_type($file))[1];
            $extension =  explode('+', $extension)[0] ;
            $file_name = Str::uuid().".".$extension;
            if (!$options->mime_type) {
                $upload = $options->model->addMediaFromBase64($file)->usingFileName($file_name);
            } else {

                $upload = $options->model->addMediaFromBase64($file, $options->mime_type)->usingFileName($file_name);
            }
        } else if ($options->request_type == 'url') {
            if (!$options->mime_type) {
                $upload = $options->model->addMediaFromUrl($file);
            } else {
                $upload = $options->model->addMediaFromUrl($file, $options->mime_type);
            }

        }
        if ($options->order_column > 0)
            $upload->setOrder($options->order_column);
        $upload->toMediaCollection($options->collection_name);
        return $upload;
    }


    /**
     * @param model $model [required]
     * @param string|array $files [required]
     * @param string $delete_type [optional][default:original_url]
     * @return bool
     */
    function deleteMedia($model, $files, $delete_type = "original_url"): bool
    {
        try {
            $files_data = [];
            if (is_string($files)) {
                $files_data[] = $files;
            } else if (is_array($files)) {
                $files_data = $files;
            }
            $model->getMedia('*')->whereIn($delete_type, $files_data)->each(function ($item) {
                $item->delete();
            });
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }


    /**
     * @param model $model [required]
     * @param string|array $collection_name [optional]
     * @return \Exception|true
     */

    /**
     * @param array $collections [required]
     * @param model $model [required]
     * @return void
     */
    function deleteCollections($collections, $model): void
    {
        $collections->each(function ($collection) use ($model) {
            $model->clearMediaCollection($collection);
        });
    }


    function
    deleteAllMedia($model, $collection_name = false): true|\Exception
    {
        try {
            if ($collection_name) {
                if (is_string($collection_name)) {
                    $model->clearMediaCollection($collection_name);
                }
                if (is_array($collection_name)) {
                    $collections = collect($collection_name);
                    $this->deleteCollections($collections, $model);
                }
            } else {
                $collections = $model->getMedia('*')->pluck('collection_name')->unique();
                $this->deleteCollections($collections, $model);
            }
            return true;
        } catch (\Exception $exception) {
            return $exception;
        }
    }


    function deleteMediaByAttribute($firstModelData, $withOutExistMediaData = [], $collectionName = null, $attribute = 'uuid'): void
    {
        $all_media = $firstModelData->getMedia($collectionName ?? '*');
        $all_media->whereNotIn($attribute, $withOutExistMediaData)->each(function ($media) {
            $media->delete();
        });
    }


    function mediaGallery($model, $column = false, $value = false)
    {
        try {
            if (!$column || !$value) {
                $query = Media::query();
            } else {
                $ids = $model::where($column, $value)->pluck('id');
                $query = Media::where('model_type', $model)->whereIn('model_id', $ids);
            }
            return $query->get()->map(function ($media) {
                return [
                    'file_name' => $media->file_name,
                    'uuid' => $media->uuid,
                    'url' => $media->getUrl()
                ];
            });
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }


    function changeMedia($model, $files, $move_to, $exit_move_to = false, $condition = 'original_url', $new_order = -1): bool
    {
        try {
            $files_data = [];
            if (is_string($files)) {
                $files_data[] = $files;
            } else if (is_array($files)) {
                $files_data = $files;
            }

            if ($exit_move_to) {
                $model->getMedia($move_to)->each(function ($item) use ($exit_move_to) {
                    $item->update(['collection_name' => $exit_move_to]);
                });
            }
            if ($new_order > 0) {
                $model->getMedia($move_to)->whereIn($condition, $files_data)->each(function ($item) use ($new_order) {
                    $item->update(['order_column' => $new_order]);
                });
            }

            $model->getMedia('*')->whereIn($condition, $files_data)->each(function ($item) use ($move_to) {
                $item->update([
                    'collection_name' => $move_to
                ]);
            });
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
