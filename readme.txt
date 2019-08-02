1. Задать id в CRMWeb\domains\tc3.my\config\crm.php

Узнать можно так: 
select cu.id, co.crm_queue__oid, co.id from crm.crm_officer co, crm.crm_user cu 
where cu.id = co.crm_user__id and cu.e_mail like '%agorokhov%' and cu.amnd_state = 'A' and co.amnd_state = 'A'
order by co.id desc

первая строчка

2. Логин/пароль в 
c:\CRMWeb\domains\tc3.my\config\oracledb.php


3. Запускаешь сервер 
c:\CRMWeb\Open Server x64.exe
В трее появится флажок. 
Right click => Run Server

Будет доступно по хосту crm.my
Ссылки:
 http://crm.my/my_cases    
 http://crm.my/case/C1611245515   (по case idt)
 или 
 http://crm.my/case/I1612129459   (по issue idt)
