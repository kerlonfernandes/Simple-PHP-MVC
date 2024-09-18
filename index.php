<?php
require_once __DIR__."/_app/Configurations.php";
require __DIR__.'/core/Core.php';
require __DIR__.'/router/routes.php';


spl_autoload_register(callback: function($class): void{
    // converte o namespace em caminho de diretório
    $classPath = str_replace(search: '\\', replace: DIRECTORY_SEPARATOR, subject: $class);
    
    // diretórios das classes

    $directories = [
        __DIR__ . "/utils/",
        __DIR__ . "/models/",
        __DIR__ . "/classes/",
        __DIR__ . "/controllers/",
        // se necessário, adicionar mais diretórios para procurar as classes 
    ];
    
    // procura o arquivo da classe em cada diretório e inclui
    foreach ($directories as $directory) {
        $file = $directory . $classPath . '.php';
        if (file_exists($file)) {
            require_once $file;
            // echo "Classe $class carregada de $file";
            return;
        }
    }
    
    // echo "Classe $class não encontrada.\n";
});

// inclui arquivos que não são classes ou que precisam ser carregados primeiro



// instancia a classe Core e roda a aplicação
$core = new Core();
$core->run($routes); 
