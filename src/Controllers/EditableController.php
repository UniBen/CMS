<?php namespace UniBen\CMS\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ReflectionClass;
use ReflectionException;
use UniBen\CMS\Exceptions\UpdateFailedException;

/**
 * Class EditableController
 * @package UniBen\CMS\Controllers
 */
class EditableController extends Controller {
    /**
     * @param Request $request
     *
     * @todo Check the classes being reflected are not evil and perform permissions check as soon as possible.
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
            /** @var self $model */
            $model = (new ReflectionClass($modelString))->newInstanceWithoutConstructor();
        } catch (ReflectionException $e) {
            throw new UpdateFailedException("Couldn't find model to update.");
        }

        $data = $model->transform($request->input('data', []));
        $id = $intent->i;

        try {
            return $model::updateOrCreate(
                [$model->getKeyName() => $id],
                $data
            );
        } catch (QueryException $exception) {
            throw new UpdateFailedException($exception->getPrevious()->getMessage());
        }
    }}
