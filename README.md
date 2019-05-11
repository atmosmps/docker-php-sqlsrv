# docker-php-sqlsrv

*Imagens Docker com configurações de conexão do PHP com SQLServer utilizando o FreeTDS lib e o Mssql lib.*

## docker-php-freetds

Esta é uma imagem do PHP 7.3 com Apache que está pré configurada para realizar a conexão com SQL Server. A configuração utiliza o [freeTDS](http://www.freetds.org/).

## docker-php-mssql

Esta é uma imagem do PHP 7.2 com Apache que está pré configurada para realizar a conexão com SQL Server. A configuração utiliza o [msphpsql](https://github.com/Microsoft/msphpsql).

*P.S: os arquivos `docker-compose.yml` neste repositório são para funs de teste locais e também podem serviro como modelo para uso em outros repositórios ou projetos.*

**TO DO**

- [ ] Separar imagens por contexto: criar somente uma do PHP e Depois uma baseada nesta com Apache.
- [ ] Criar imagem com Nginx.
- [ ] Criar imagem baseada em alguma Slim.
- [ ] Integrar com [PHP DBlib](http://php.net/manual/en/ref.pdo-dblib.php)

--------------------------------------------------
