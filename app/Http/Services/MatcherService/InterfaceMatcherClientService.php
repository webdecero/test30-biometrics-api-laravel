<?php
namespace App\Http\Services\MatcherService;

interface InterfaceMatcherClientService
{
    public function store( $subjectId, $name, $email, $terminal_key);
    public function update( $subjectId, $name, $email, $terminal_key, $data);
    public function show($subjectId);
    public function matcher($content);
}
