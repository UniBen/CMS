<?php namespace UniBen\CMS\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ReflectionClass;
use ReflectionException;
use UniBen\CMS\Exceptions\UpdateFailedException;
use UniBen\CMS\Models\Editable;

/**
 * Class EditableController
 * @package UniBen\CMS\Controllers
 */
class EditableController extends Controller {
    /**
     * @param Request $request
     *
     * @return mixed
     * @throws UpdateFailedException
     */
    public function update(Request $request) {
        // Decode intent
        $intent = json_decode(base64_decode($request->input('intent')));

        try {
            $editableClass = (new ReflectionClass($request->input('type')))->newInstanceWithoutConstructor();
        } catch (ReflectionException $e) {
            throw new UpdateFailedException('Unable to find field type to update.');
        }

        $modelString = $intent->m;

        try {
            /** @var Editable $model */
            $model = (new ReflectionClass($modelString))->newInstanceWithoutConstructor();
        } catch (ReflectionException $e) {
            throw new UpdateFailedException("Couldn't find model to update.");
        }

        if (!$model->canEdit()) abort(403, 'Permission denied.');

        $data = $request->input('data');

        try {
            $model = $model::find($intent->i) ?? $model;
            $keys = array_merge(array_flip($model->getFillable()), $model->getAttributes());

            $model->editable()->updateOrCreate([], [
                'data' => array_diff_key($data, $keys)
            ]);

            foreach (array_intersect_key($data, $keys) as $property => $data) {
                $model->$property = $data;
            }

            $model->save();

            return $model;
        } catch (QueryException $exception) {
            if ($exception->getCode() === 'HY000') {
                throw (new UpdateFailedException($exception->getMessage() . '. Make sure the the attribute is fillable.'))
                    ->setData([$data])
                    ->setIntent($request->input('intent'))
                    ->setModel($model);
            }

            throw $exception;
        } catch (QueryException $exception) {
            throw (new UpdateFailedException($exception->getPrevious()->getMessage()))
                ->setData([$data])
                ->setIntent($request->input('intent'))
                ->setModel($model);
        }
    }
}
