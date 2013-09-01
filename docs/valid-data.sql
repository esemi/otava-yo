

INSERT INTO `album` (`id`, `title`, `year`, `desc`) VALUES
(1, 'Рождество', 2011, ''),
(2, 'Жили-были', 2009, ''),
(3, 'Под аптекой', 2006, '<p>Альбом записанный группой по следам своих выступлений на Невском проспекте в городе Санкт-Петербург. Совершенно случайным образом музыканты вдруг решили собраться и поиграть на улице именно группой. К тому времени у всех нынешних участников группы уже был богатый опыт уличных выступлений, но в основном заграницей. Первый совместный опыт игры в Петербурге на улице группой оказался настолько позитивным, что с этого момента Отава ё стали регулярно выступать около гомеопатический аптеки на Невском проспекте. Отсюда и название альбома — «Под аптекой».</p>\n<p>Репертуар состоял в основном из кельтских мелодий. Практически все аранжировки были сделаны в процессе уличных концертов. Чтобы сохранить концертный дух, альбом «Под аптекой» был записан живьём на Петербургской студии грамзаписи, с небольшими дописками сделанными на студии «Часовщик».  Звук и концепция альбома получились вполне адекватными состоянию группы на тот момент.</p> \n<p>По принципиальным соображениям «Под аптекой» был издан без участия выпускающих лэйблов, то есть своими силами, в формате диджипак на деньги вырученные от уличных выстулпений. </p>\n<p class="title-em">В записи приняли участие:</p>\n<ul class="list">\n<li><span class="bold">Алексей Белкин</span> — галисийская волынка, shuttle pipe, жалейка, вокал</li>\n<li><span class="bold">Дмитрий Шихардин</span> — фиддл, вокал</li>\n<li><span class="bold">Алексей Скосырев</span> — акустическая гитара, вокал</li>\n<li><span class="bold">Наталья Высоких</span> — скрипка</li>\n<li><span class="bold">Пётр Сергеев</span> — дарбука</li>\n<li><span class="bold">Светлана Кондесюк</span> — галисийская волынка, флейта</li>\n<li><span class="bold">Роман Стансков</span> — бузуки</li>\n</ul>\n<p>К сожалению, с тех пор в нашем городе многое изменилось и музыкантам группы Отава ё больше не дают играть на улице ссылаясь на то, что это не разрешено и является незаконной коммерческой деятельностью. Так что на сегодняшний день альбом «Под аптекой» — единственное место где возможно услышать музыку уличных музыкантов в нашем городе. </p>\n');



INSERT INTO `audio` (`id`, `album_id`, `title`) VALUES
(1, 1, 'Как в Иерусалиме рано зазвонили'),
(2, 1, 'Днесь Христос родился'),
(3, 1, 'Христос Спаситель'),
(4, 1, 'На небе зорька'),
(5, 1, 'Рождество Христово, ангел прилетел'),
(6, 1, 'Небо и земля'),
(7, 1, 'Уродилась коляда'),
(8, 1, 'Запевайте, христиане'),
(9, 1, 'Эта ночь святая'),
(10, 1, 'Торжествуйте, веселитесь'),
(11, 2, 'Интро'),
(12, 2, 'Кадриль'),
(13, 2, 'Жил-был у бабушки серенький козлик'),
(14, 2, 'Про Ивана groove'),
(15, 2, 'Лезгинка'),
(16, 2, 'Гавоты'),
(17, 2, 'Про Диму и Петю'),
(18, 2, 'Во кузнице'),
(19, 2, 'Финская полька'),
(20, 2, 'Иванушка рачек'),
(21, 2, 'Риорита'),
(22, 2, 'Крутится вертится шарф голубой'),
(23, 3, 'Reels'),
(24, 3, 'Saltarella / Tarantella'),
(25, 3, 'Bailar'),
(26, 3, 'Польки / Найман'),
(27, 3, 'Джиги'),
(28, 3, 'Шведская'),
(29, 3, 'La sansonette'),
(30, 3, 'Lazersong'),
(31, 3, 'Песня'),
(32, 3, 'Хит'),
(33, 3, 'Вальс Петрова');

UPDATE `otava`.`album` SET `title` = 'Под аптекой',
`desc` = 'Наш первый альбом' WHERE `album`.`id` =3;