<?php

class Cripto
{
    private $user = 'root';
    private $pass = '';
    private $dbname = 'pcripto';
    private $host = 'localhost';
    private $conn;

    /**
     * Conexão com o banco de dados
     */
    public function Database()
    {
        $this->conn = new PDO(
            "mysql:host={$this->host}; dbname={$this->dbname}; charset=UTF8",
            $this->user,
            $this->pass
        );
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this->conn;
    }

    /**
     * Listar todos
     */
    function index()
    {
        try {
            $consulta = $this->conn->prepare("SELECT * FROM balance ORDER BY wallet, api_id");
            $consulta->execute();
            $result = $consulta->fetchAll();
            return $result;
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
    }

    /**
     * Adicionar
     */
    function store($request)
    {
        try {
            $consulta = $this->conn->prepare("INSERT INTO balance (wallet, api_id, balance) values (:wallet, :api_id, :balance)");
            $result = $consulta->execute([
                ':wallet'  => $request['wallet'],
                ':api_id'  => $request['api_id'],
                ':balance' => str_replace(",", ".", $request['balance'])
            ]);
            return $result;
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
    }

    /**
     * Listar unico
     */
    function show($request)
    {
        try {
            $consulta = $this->conn->prepare("SELECT * FROM balance WHERE id=:id");
            $result = $consulta->execute([
                ':id'      => $request['id']
            ]);
            $result = $consulta->fetchObject();
            return $result;
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
    }

    function update($request)
    {
        try {
            $consulta = $this->conn->prepare("UPDATE balance set balance=:balance WHERE id=:id");
            $result = $consulta->execute([
                ':id'      => $request['id'],
                ':balance' => str_replace(",", ".", $request['balance'])
            ]);
            return $result;
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
    }

    function destroy($request)
    {
        try {
            $consulta = $this->conn->prepare("DELETE FROM balance WHERE id=:id");
            $result = $consulta->execute([
                ':id'      => $request['id']
            ]);
            return $result;
        } catch (PDOException $err) {
            echo $err->getMessage();
        }
    }

    function consultaApi($moeda = 'bitcoin', $opt = 'symbol')
    {
        $search = [",", "$"];
        $replace = ["", ""];

        $url = "https://www.coingecko.com/en/coins/{$moeda}";
        $content = file_get_contents($url);
        preg_match_all('/<span class="tw-text-gray-900 dark:tw-text-white tw-text-3xl">(.*?)<\/span>/s', $content, $current_price);
        preg_match_all('/<div class="mr-md-3 tw-pl-2 md:tw-mb-0 tw-text-xl tw-font-bold tw-mb-0">(.*?)<\/div>/s', $content, $name);
        preg_match_all('/<div class="tw-flex tw-text-gray-900 dark:tw-text-white tw-mt-2 tw-items-center">(.*?)src="(.*?)"(.*?)<div/s', $content, $image);
        preg_match_all('/data-target="percent-change.percent" (.*?)>(.*?)<\/span>/s', $content, $perc24h);
        if ($opt == 'name') return trim(explode("(", strip_tags($name[0][0]))[0]);
        if ($opt == 'image') return $image[2][0];
        if ($opt == 'symbol') return explode(")", explode("(", strip_tags($name[0][0]))[1])[0];
        if ($opt == 'price') return trim(str_replace($search, $replace, strip_tags($current_price[0][0])));
        if ($opt == 'perc24h') return substr(strip_tags(explode(">", $perc24h[0][0])[1]), 0, -1);
    }
}
