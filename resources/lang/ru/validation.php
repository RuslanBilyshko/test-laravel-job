<?php return [
  'custom' => [
    'title' => [
      'min' => 'Поле должно содержать не менее :min символов',
    ],
    'name' => [
      'min' => 'Поле должно содержать не менее :min символов',
    ],
    'l_row' => [
      'max' => 'Должно быть меньше или равно :max'
    ],
    'l_seat' => [
      'max' => 'Должно быть меньше или равно :max'
    ],
    'r_row' => [
      'min' => 'Должно быть больше или равно :min'
    ],
    'r_seat' => [
      'min' => 'Должно быть больше или равно :min'
    ],
    'password' => [
      'same' => 'Пароли не совпадают',
      'confirmed' => 'Пароли не совпадают',
      'min' => 'Поле должно содержать не менее :min символов',
      'required_with' => 'Поле подтверждения пароля требуется если пароль присутствует.',
    ],
    'password_confirmation' => [
      'same' => 'Пароли не совпадают',
      'required_with' => 'Поле подтверждения пароля требуется если пароль присутствует.'
    ],
    'cashbox' => [
      'required_if' => 'Укажите кассу'
    ],
    'login' => [
      'regex' => 'Поле должно содержать только латинские символы, цифры, знаки подчёркивания (_)',
      'unique' => 'Этот логин уже занят'
    ],
    'email' => [
      'unique' => 'Этот E-mail уже занят'
    ],
    'phone' => [
      'regex' => 'Поле может содержать только цифры 0-9, знаки - + и ()',
    ],
    'phone2' => [
      'regex' => 'Поле может содержать только цифры 0-9, знаки - + и ()',
    ],
    'phone3' => [
      'regex' => 'Поле может содержать только цифры 0-9, знаки - + и ()',
    ],
    'phone4' => [
      'regex' => 'Поле может содержать только цифры 0-9, знаки - + и ()',
    ],
    'number' => [
      'required_with' => 'Укажите день',
    ],
    'month' => [
      'required_with' => 'Укажите месяц',
    ],
    'year' => [
      'required_with' => 'Укажите год',
    ],
    'img' => [
      'max' => 'Изображение не может быть больше :max килобайт.'
    ],



  ],
  'required' => 'Поле обязательно для заполнения.',
  'min' => 'Поле должно содержать не менее :min',
  'date' => 'Неверный формат - 31.12.2016',
  'numeric' => 'Поле должно содержать только цифры 0 - 9',
  'email' => 'Некорректный E-mail адресс',
  'mimes' => 'Недопустимый формат файла',


];
