<?php

/**
 * Класс для осуществления запросов в бд
 * содержит общие методы
 */
class QueryBuilder
{
// имя таблицы, с которой будем работать
    private $table;
    public function __construct($table)
    {
        $this->table=$table;
    }

    /**
     * Сохранеем базу в удобочитаемом виде
     * @param  $fields array - данные для сохранения
     * @return bool
     */
    public function saver($fields)
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        if(file_exists('xml/'.$this->table.'.xml'))
            $dom->loadXML($fields->asXML());
        else
            $dom->appendChild($dom->createElement($this->table));
        return ($dom->save('xml/'.$this->table.'.xml'))?true:false;
    }

    /**
     * Добавляем в базу новые дочерние узлы
     * @param  $data array - массив данных, который нужно добавить в новый дочерний узер ['имя_поля' =>'значение']
     * @return после добавления отправляем запрос на охранение
     */
    public function add($data)  
    {
        if(!file_exists('xml/'.$this->table.'.xml'))
            $this->saver($fields);
        $fields=@simplexml_load_file('xml/'.$this->table.'.xml');
        $field = $fields->addChild(rtrim($this->table, 's'));
        $field->addAttribute('id', $fields->count());
        foreach($data as $key=>$value)
        {
            $field->addChild($key,$value);
        }
        return $this->saver($fields);
    }

    /**
     * Проверяем есть ли поле с таким значением в базе
     * @param  $field string - какое поле искать
     * @param  $search string - какое значение в этом поле искать
     * @return bool
     */
    public function find($field,$search)
    {
        if(!file_exists('xml/'.$this->table.'.xml'))
            return false;
        $fields=@simplexml_load_file('xml/'.$this->table.'.xml');
        return empty($fields->xpath("//${field}[text()='${search}']"))?false:true;
    }

    /**
     * Получем из базы данные
     * @param  $searchField array - по какому опОрному полю искать
     * @param  $whichFields array - какие данные хотим получить
     * @return array
     */
    public function getDataByAnything($searchField, $whichFields)
    {
        if(!file_exists('xml/'.$this->table.'.xml')) // если такого файла не существует->база еще не создана->дубликатов нету
            return false; 
        $fields=@simplexml_load_file('xml/'.$this->table.'.xml');
        $searchKey=key($searchField);
        $data=[];
        foreach($fields->children() as $field)
        {
            if($field->$searchKey==$searchField[$searchKey])
                foreach($whichFields as $whichField)
                    $data[$whichField]=strval($field->$whichField);
        }
        if(empty($data) || $data[$whichField]==='')
            return false;
        return $data;
    }

    /**
     * Получаем массив - вся информация о пользователе
     * @param $searchField array - по какому полю ищем ['название поля'=>'значение поля']
     * @return array - в случае успеха, иначе false
     */
    public function getData($searchField) 
    {
        if(!file_exists('xml/'.$this->table.'.xml')) // если такого файла не существует
            return false; 
        $fields=@simplexml_load_file('xml/'.$this->table.'.xml');
        $searchKey=key($searchField);
        $data=[];
        foreach($fields->children() as $field)// проходим по дочерним элементам
        {
            if(strval($field->$searchKey)===$searchField[$searchKey])// если нашли нужное поле с нужным значением,то сохраняем все данные пользователя в массив
            {
                $data['id']=intval($field['id']);
                foreach($field as $newField)
                {
                    $data[$newField->getName()]=strval($newField);
                }
                // если нашли->выходим из цикла foreach
                break;
            }
        }
        return empty($data)?false:$data;
    }

    /**
     * Добавляем ключ куки/сессии в базу
     * @param  $where string - куда добавляем(куки/сессия)
     * @param  $id int - ид пользователя
     * @param  $key string - значения ключа
     * @return 
     */
    public function addKey($where, $id, $key)
    {
        if(!file_exists('xml/'.$this->table.'.xml')) // если такого файла не существует
           return false;
        $fields=@simplexml_load_file('xml/'.$this->table.'.xml');
        foreach($fields->children() as $field)
        {
            if(intval($field['id'])===$id)
                $field->$where=$key;
        }
        return $this->saver($fields);
    }
}