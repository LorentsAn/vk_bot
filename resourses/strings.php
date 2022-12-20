<?php

const VALID_MAKE_TASK_COMMAND = "\𝗆𝖺𝗄𝖾_𝗍𝖺𝗌𝗄 𝗇𝖺𝗆𝖾 = '𝖳𝖺𝗌𝗄 𝗇𝖺𝗆𝖾' 𝖽𝖺𝗍𝖾 = '𝟤𝟢𝟤𝟤-𝟣𝟢-𝟥𝟣' [𝗍𝖺𝗌𝗄 = '𝖳𝖺𝗌𝗄 𝖣𝖾𝗌𝖼𝗋𝗂𝗉𝗍𝗂𝗈𝗇'] [𝖼𝗈𝗌𝗍 = 𝟣𝟢]";
const VALID_CLOSE_TASK_COMMAND = "\𝖼𝗅𝗈𝗌𝖾_𝗍𝖺𝗌𝗄 𝗇𝖺𝗆𝖾 = '𝖳𝖺𝗌𝗄 𝗇𝖺𝗆𝖾' [𝗂𝗌_𝖼𝗈𝗆𝗉𝗅𝖾𝗍𝖾𝖽 = '𝗒𝖾𝗌'] ";
const VALID_GET_SCORE_COMMAND = "\𝗀𝖾𝗍_𝗌𝖼𝗈𝗋𝖾";
const VALID_GET_ALL_TASK_COMMAND = "\𝗀𝖾𝗍_𝖺𝗅𝗅_𝗍𝖺𝗌𝗄";

const HELP_INFORMATION = "Привет! Это бот которые поможет тебе управляться со своими дедлайнами и задачами! \n
Каждое успешно выполенное задание стоит баллы - они показатель важности того или иного дела. Зарабатывая баллы ты можешь мотивировать себя в учебной группе и держать свои дела под контролем. \n
Перечень команд: \n "
    . VALID_MAKE_TASK_COMMAND ." 
    \t ^ Создать новую задачу. Обрати внимание на формат даты выполнения. По умолчанию цена задачи - 10 баллов. \n"
    . VALID_GET_SCORE_COMMAND . " 
    \t ^ Узнать сколько у тебя баллов. \n"
    . VALID_GET_ALL_TASK_COMMAND . "
    \t ^ Посмотреть все задачи, которые ты себе ставил. \n"
    . VALID_CLOSE_TASK_COMMAND . "
    \t ^ Отметить задачу как завершенную. Если отметить is_completed как no, то задача удаляется из списка и не отмечается как завершенная. По умолчанию отмечается как выполненная.";

const INFORMATION_ABOUT_BALANCE = "Ваши баллы: %s";
const INFORMATION_ABOUT_TASK = "========%s======== \n %s \n Необходимо закончить это к \"%s\" за \"%s\" баллов \n";
const INFORMATION_ABOUT_STATUS = "Вы успешно завершили задачу! Поздравляю!";
const INFORMATION_ABOUT_CLOSE_FAIL_TASK = "Надеюсь, что в следующий раз получится :( Не отчаивайтесь. Задача отмечена как не выполенная";
const INFORMATION_ABOUT_COMPLETED_TASK = "---------------\n ✅ Задание закончено. Название: %s \n Нужно было закончить к %s. Стоило %s баллов\n ---------------";
const INFORMATION_ABOUT_FAIL_TASK = "---------------\n ⚠️ Задание не было выполено :(. Название: %s \n Нужно было закончить к %s. Стоило %s баллов\n ---------------";
const INFORMATION_ABOUT_NOT_COMPLETED_TASK = "---------------\n ❌ Название: %s \n Нужно закончить к %s. Стоит %s баллов\n---------------";


const THIS_USER_DOES_NOT_HAVE_TASK = "Вы еще не планировали задач";
const TASK_WITH_NAME_ALREADY_EXIST = "Задача с таким именем уже существует. Попробуйте ввести новую или закончить старые";
const TASK_WITH_NAME_NOT_EXIST = "Задачи с таким именем не существует. Попробуйте ввести запрос еще раз";

const EMPTY_NAME_OF_TASK = "Имя задачи не должно быть пустым. Сделайте запрос еще раз.";
const EMPTY_IS_COMPLETED_FIELD = "Кажется, что вы оставили поле is_completed пустым. Сделайте запрос еще раз, чтобы я вас понял";
const EMPTY_FINISH_DATE = "У задачи обязательно должно быть время окончания. Сделайте запрос еще раз.";
const WRONG_DATA = "Дата окончания задачи введена неверно. Введите дату в формате Y-M-D, например, 2022-10-11. Дата должна быть позднее сегодняшнего дня.";
const ENTERED_PRICE_NOT_NUMBER = "Введенная цена не является числом. Сделайте запрос еще раз.";
const FEW_ARGUMENTS_FOR_MAKE_TASK = "Введено слишком мало аргументов. Правильный ввод команды: \n " . VALID_MAKE_TASK_COMMAND;
const A_LOT_ARGUMENTS_FOR_MAKE_TASK = "Введено слишком много аргументов. Правильный ввод команды: \n " . VALID_MAKE_TASK_COMMAND;
const FEW_ARGUMENTS_FOR_CLOSE_TASK = "Введено слишком мало аргументов. Правильный ввод команды: \n " . VALID_CLOSE_TASK_COMMAND;
const A_LOT_ARGUMENTS_FOR_CLOSE_TASK = "Введено слишком много аргументов. Правильный ввод команды: \n " . VALID_CLOSE_TASK_COMMAND;
const NO_REQUIRED_FIELDS_FOR_MAKE_TASK = "Вы не ввели необходимые аргументы для создания задачи. Правильный ввод команды: \n " . VALID_MAKE_TASK_COMMAND;

const NO_REQUIRED_FIELDS_FOR_CLOSE_TASK = "Вы не ввели необходимые аргументы для завершения задачи. Правильный ввод команды: \n " . VALID_CLOSE_TASK_COMMAND;
const WRONG_IS_COMPLETED_ANSWER = "Неправильный ввод параметра is_completed, валидные значения: yes/no/y/n";
const ERROR_OCCURRED = "Произошла ошибка, попробуйте сделать еще запрос";

const COMMAND = "command";
const ARGUMENTS = "args";

const YES = "yes";
const NO = "no";
const SHORT_YES = "y";
const SHORT_NO = "n";
