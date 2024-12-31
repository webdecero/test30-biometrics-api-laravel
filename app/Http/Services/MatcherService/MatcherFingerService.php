<?php
namespace App\Http\Services\MatcherService;


class MatcherFingerService extends AbstractMatcherClientService
{



  public function store( $subjectId, $name, $email, $terminal_key)
  {
    

          // Preparar el mensaje para el SocketIO
          $message = [
              'dsn' => $this->dsn,
              'table' => $this->table,
              'subjectId' => $subjectId,
              'name'=>$name,
              'email'=>$email,
              'terminal_key'=>$terminal_key
          ];

          $response = $this->socketMatcher->emit('subject', 'store', $message);

          return $response;
     
  }

  public function update( $subjectId, $name, $email, $terminal_key, $fingers)
  {
      
          // Preparar el mensaje para el SocketIO
          $message = [
              'dsn' => $this->dsn,
              'table' => $this->table,
              'subjectId' => $subjectId,
              'name'=>$name,
              'email'=>$email,
              'terminal_key'=>$terminal_key,
              'fingers'=>$fingers
          ];

          $response = $this->socketMatcher->emit('subject', 'update', $message);

          return $response;
    
  }

  public function show($subjectId)
  {
   

          // Preparar el mensaje para el SocketIO
          $message = [
              'dsn' => $this->dsn,
              'table' => $this->table,
              'subjectId' => $subjectId,
          ];

          $response = $this->socketMatcher->emit('subject', 'show', $message);

          return $response;
     
  }

  public function matcher($content)
  {
    

          $content = base64_encode(file_get_contents($content));

          // Preparar el mensaje para el SocketIO
          $message = [
              'dsn' => $this->dsn,
              'table' => $this->table,
              'content' => $content,
          ];

          $response = $this->socketMatcher->emit('subject', 'match', $message);

          return $response;
      
  }

}
