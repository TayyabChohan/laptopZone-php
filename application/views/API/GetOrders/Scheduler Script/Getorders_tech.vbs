Dim WinScriptHost
Set WinScriptHost = CreateObject("WScript.Shell")
WinScriptHost.Run Chr(34) & "C:\Users\WizmenPHP\Desktop\Getorders_tech.bat" & Chr(34), 0
Set WinScriptHost = Nothing