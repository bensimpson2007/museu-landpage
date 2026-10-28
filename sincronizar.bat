@echo off
rem Sincroniza o projeto com o GitHub: baixa o que o outro enviou e envia as suas mudancas.
cd /d "%~dp0"

echo.
echo === 1/3 Baixando alteracoes do GitHub...
git pull --rebase --autostash || goto erro

git add -A
git diff --cached --quiet && (
  echo.
  echo Nada novo para enviar. Seu projeto ja esta atualizado.
  goto fim
)

echo.
echo === 2/3 Salvando suas mudancas...
set "msg="
set /p "msg=Descreva o que mudou (ou so aperte Enter): "
if "%msg%"=="" set "msg=Atualizacao %date% %time:~0,5%"
git commit -m "%msg%" || goto erro

echo.
echo === 3/3 Enviando para o GitHub...
git push || goto erro

echo.
echo Pronto! Tudo sincronizado.
goto fim

:erro
echo.
echo Algo deu errado. Leia a mensagem acima ou peca ajuda.

:fim
echo.
pause
