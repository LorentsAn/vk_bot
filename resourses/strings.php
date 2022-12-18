<?php

const EMPTY_NAME_OF_TASK = "Имя задачи не должно быть пустым. Сделайте запрос еще раз.";
const EMPTY_FINISH_DATE = "У задачи обязательно должно быть время окончания. Сделайте запрос еще раз.";
const WRONG_DATA = "Дата окончания задачи введена неверно. Введите дату в формате Y-M-D, например, 2022-10-11. Дата должна быть позднее сегодняшнего дня.";
const ENTERED_PRICE_NOT_NUMBER = "Введенная цена не является числом. Сделайте запрос еще раз.";
const FEW_ARGUMENTS_FOR_MAKE_TASK = "Введено слишком мало аргументов. Правильный ввод команды: \n \make_task name='some name' date='2022-10-11' [task='description'] [cost='20]";
const NO_REQUIRED_FIELDS_FOR_MAKE_TASK = "Вы не ввели необходимые аргументы для создания задачи. Правильный ввод команды: \n \make_task name='some name' date='2022-10-11' [task='description'] [cost='20]";

const ERROR_OCCURRED = "Произошла ошибка, попробуйте сделать еще запрос";

const COMMAND = "command";
const ARGUMENTS = "args";
