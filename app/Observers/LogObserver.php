<?php

namespace App\Observers;

use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log as LaravelLog;

class LogObserver
{
    public function created(Model $model)
    {
        $this->log('INSERT', $model);
    }

    public function updated(Model $model)
    {
        $this->log('UPDATE', $model);
    }

    public function deleted(Model $model)
    {
        // Agregar registro de depuración
        LaravelLog::info('Se ha llamado al método deleted en LogObserver para el modelo: ' . get_class($model));
        $this->log('DELETE', $model);
    }

    private function log($action, Model $model)
    {
        $table = $model->getTable();
        $record_id = $model->id;
        $user_name = Auth::user() ? Auth::user()->name : 'Admin';

        $executedSQL = $this->getExecutedSQL($action, $model);
        $reverseSQL = $this->getReverseSQL($action, $model);

        Log::create([
            'action' => $action,
            'table' => $table,
            'record_id' => $record_id,
            'executedSQL' => $executedSQL,
            'reverseSQL' => $reverseSQL,
            'user_name' => $user_name,
        ]);
    }

    private function getExecutedSQL($action, $model)
    {
        $table = $model->getTable();
        $record_id = $model->id;
        $attributes = $model->getAttributes();

        if ($action === 'INSERT') {
            $columns = implode(', ', array_keys($attributes));
            $values = implode("', '", array_values($attributes));
            return "INSERT INTO $table ($columns) VALUES ('$values')";
        } elseif ($action === 'UPDATE') {
            $updates = [];
            foreach ($attributes as $key => $value) {
                $updates[] = "$key = '$value'";
            }
            $updates = implode(', ', $updates);
            return "UPDATE $table SET $updates WHERE id = $record_id";
        } elseif ($action === 'DELETE') {
            return "DELETE FROM $table WHERE id = $record_id";
        }

        return '';
    }

    private function getReverseSQL($action, $model)
    {
        $table = $model->getTable();
        $record_id = $model->id;
        $attributes = $model->getAttributes();

        if ($action === 'INSERT') {
            return "DELETE FROM $table WHERE id = $record_id";
        } elseif ($action === 'UPDATE') {
            $old_values = $model->getOriginal();
            $updates = [];
            foreach ($old_values as $key => $value) {
                $updates[] = "$key = '$value'";
            }
            $updates = implode(', ', $updates);
            return "UPDATE $table SET $updates WHERE id = $record_id";
        } elseif ($action === 'DELETE') {
            unset($attributes['id']);
            $columns = implode(', ', array_keys($attributes));
            $values = implode("', '", array_values($attributes));
            return "INSERT INTO $table ($columns) VALUES ('$values')";
        }

        return '';
    }
}
