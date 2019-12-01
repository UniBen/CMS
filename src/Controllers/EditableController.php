<?php namespace UniBen\CMS\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ReflectionClass;
use ReflectionException;
use UniBen\CMS\Exceptions\UpdateFailedException;
use UniBen\CMS\Models\Editable;

class EditableController extends Controller {
    public function update(Request $request) {
        $data = $request->input();

        // Decode intent
        $intent = json_decode(base64_decode($data['intent']));

        // Get value
        $value = $data['value'];

        /**
         * @var string $modelString
         * @var Editable $model
         * @var string $field
         * @var int $id
         */
        $modelString = $intent->m;

        try {
            $model = (new ReflectionClass($modelString))->newInstanceWithoutConstructor();
        } catch (ReflectionException $e) {
            throw new UpdateFailedException("Couldn't find model to update.");
        }

        $field = $intent->f;
        $id = $intent->i;

        try {
            return $model::updateOrCreate(
                [$model->getKeyName() => $id],
                [$field => $value]
            );
        } catch (QueryException $exception) {
            throw new UpdateFailedException($exception->getPrevious()->getMessage());
        }
    }}
