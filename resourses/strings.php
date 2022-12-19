<?php

const INFORMATION_ABOUT_BALANCE = "Ваши баллы: \"%s\"";
const INFORMATION_ABOUT_TASK = "========%s======== \n %s \n Необходимо закончить это к \"%s\" за \"%s\" баллов \n";
const INFORMATION_ABOUT_COMPLETED_TASK = "---------------\n ✅ Задание закончено. Название: %s \n Нужно было закончить к %s. Стоило %s баллов\n ---------------";
const INFORMATION_ABOUT_NOT_COMPLETED_TASK = "---------------\n ❌ Название: %s \n Нужно закончить к %s. Стоило %s баллов\n---------------";


const THIS_USER_DOES_NOT_HAVE_TASK = "Вы еще не планировали задач";
const TASK_WITH_NAME_ALREADY_EXIST = "Задача с таким именем уже существует. Попробуйте ввести новую или закончить старые";
const EMPTY_NAME_OF_TASK = "Имя задачи не должно быть пустым. Сделайте запрос еще раз.";
const EMPTY_FINISH_DATE = "У задачи обязательно должно быть время окончания. Сделайте запрос еще раз.";
const WRONG_DATA = "Дата окончания задачи введена неверно. Введите дату в формате Y-M-D, например, 2022-10-11. Дата должна быть позднее сегодняшнего дня.";
const ENTERED_PRICE_NOT_NUMBER = "Введенная цена не является числом. Сделайте запрос еще раз.";
const FEW_ARGUMENTS_FOR_MAKE_TASK = "Введено слишком мало аргументов. Правильный ввод команды: \n \make_task name='some name' date='2022-10-11' [task='description'] [cost='20]";
const NO_REQUIRED_FIELDS_FOR_MAKE_TASK = "Вы не ввели необходимые аргументы для создания задачи. Правильный ввод команды: \n \make_task name='some name' date='2022-10-11' [task='description'] [cost='20]";

const ERROR_OCCURRED = "Произошла ошибка, попробуйте сделать еще запрос";

const COMMAND = "command";
const ARGUMENTS = "args";
