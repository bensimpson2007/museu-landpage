@echo off
rem Compila o SCSS (pasta scss) para o CSS que o site usa (assets\css\style.css).
rem Dois cliques: compila uma vez. Para recompilar sozinho a cada mudanca: compilar-css.bat vigiar
cd /d "%~dp0"

set "SASS=sass"
where sass >nul 2>nul || set "SASS=%USERPROFILE%\ferramentas\dart-sass-1.107.0\dart-sass\sass.bat"
if not exist "%SASS%" if not "%SASS%"=="sass" (
  echo.
  echo Dart Sass nao encontrado.
  echo Baixe o "windows-x64.zip" em https://github.com/sass/dart-sass/releases
  echo e descompacte em %USERPROFILE%\ferramentas\dart-sass-1.107.0
  goto fim
)

if /i "%~1"=="vigiar" (
  echo Vigiando a pasta scss... salve um arquivo .scss e o CSS e atualizado. Ctrl+C para parar.
  call "%SASS%" --no-source-map --style=compressed --watch scss/main.scss assets/css/style.css
  goto fim
)

echo.
echo Compilando scss\main.scss para assets\css\style.css...
call "%SASS%" --no-source-map --style=compressed scss/main.scss assets/css/style.css && (
  echo.
  echo Pronto! CSS atualizado.
) || (
  echo.
  echo Deu erro no SCSS. Leia a mensagem acima: ela mostra o arquivo e a linha.
)

:fim
echo.
pause
