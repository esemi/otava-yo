
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `otava`
--

--
-- Dumping data for table `concert`
--

INSERT INTO `concert` (`id`, `date`, `title`, `link`, `place`, `time`, `cost`, `desc`) VALUES
(1, '2013-08-23', 'Latvia, Цесис', 'http://www.mjr.lt/arc/mjr2012/en/festival/about-festival', '', '18:30:00', NULL, 'Фестиваль организованный лэйблом Lauska по поводу своего юбилея и выхода нового сборника Sviests 5 с нашим участием.'),
(2, '2013-08-12', 'Рыба в рыбе', '', 'СПб, клуб А2 (зал "Мир"),проспект Медиков 3', '23:15:00', 500, 'атата и нету описания'),
(3, '2013-08-30', 'Рыбонька', 'http://www.mjr.lt/arc/mjr2012/en/festival/about-festival', 'СПб, клуб А2 (зал "Мир"),проспект Медиков 3', NULL, NULL, 'немного описания ещё');

--
-- Dumping data for table `guestbook`
--

INSERT INTO `guestbook` (`id`, `author`, `date_publish`, `email`, `city`, `site`, `content`) VALUES
(1, 'ОтаваЁ', '2013-08-22 09:12:34', 'otava@otava.ru', 'СПб', 'otava.ru', 'Внимание, внимание - ближайшее наше выступление будет на XIV международном фолк-фестивале "День Святого Патрика в СПб" - 16го марта 2013 года, в самом большом клубе города - А2 (зал МИР). Начало в 20.00. www.patrickfestival.ru '),
(2, 'Pavel', '2013-08-23 00:20:42', '', '', '', 'Привет! Расписание на Патрик есть? кто когда играет по времени?');

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `date_publish`, `title`, `content`) VALUES
(1, '2013-05-06', 'Запись нового альбома', 'мы вышли на финишную прямую в записи нового альбома! Осталось буквально 2-3 сессии на студии и можно будет сказать, что главная часть работы сделана. После этого весь материал будет переправлен в Латвию на Рижскую студию GEM, где звукорежиссёр Гатис Гауяниекс будет заниматься сведением, после этого сведённый материал уедет в Германию, где будет сделан мастеринг. Эта схема работы нами опробована на двух предыдущих альбомах.\r\n<br><br>\r\nНовый альбом – это накопившийся материал за последние 4 года, песни всем известные и не очень. На данном альбоме мы продолжили развивать и пестовать тему рашн бит.\r\n<br><br>\r\nБудучи несвязанными никакими контрактными обязательствами – мы записывались спокойно без спешки, позволяя себе различные эксперименты. В самом ближайшем будущем выложим что-нибудь послушать. Выпуск альбома планируется на осень 2013 года. Как всегда новый альбом будет издан на компакт дисках и выложен на нашей странице на кругах.\r\n<br><br>\r\nЛето 2013 обещает быть насыщенным – есть несколько предложений от европейских фестивалей. В планах поездки в Эстонию, Латвию, Австрию и Финляндию! Финляндию хочется отметить особо, так как это будет наша первая поездка за долгие годы в Финляндию с концертами. До этого, как вы знаете, мы были там только в качестве уличных музыкантов и проездом в аэропорт. Теперь настало время возвращать долги. В июле мы выступим на одном из старейших и уважаемых фолк фестивалей - Kaustinen folk festival.\r\n<br><br>\r\nВ середине мая мы выступим в Москве в клубе Шоколадная фабрика, а 2го июня в Петербурге в клубе DaDa, тем самым закроем клубный сезон и перейдём к фестивалям. ');

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `player_code`, `desc`) VALUES
(1, '<object height="385" width="480"><param value="http://www.youtube.com/v/ps9RqYpdkX0?fs=1&amp;hl=en_US" name="movie"><param value="true" name="allowFullScreen"><param value="always" name="allowscriptaccess"><embed height="385" width="480" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" src="http://www.youtube.com/v/ps9RqYpdkX0?fs=1&amp;hl=en_US" quality="low"><param name="quality" value="low"></object>', 'Эфир на канале СТО, 24го Сентября 2009 года. Авторская мелодия А. Белкина, слова народные'),
(2, '<object height="385" width="640"><param value="http://www.youtube.com/v/Ui2oKFXPHxI?fs=1&amp;hl=en_US" name="movie"><param value="true" name="allowFullScreen"><param value="always" name="allowscriptaccess"><embed height="385" width="640" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" src="http://www.youtube.com/v/Ui2oKFXPHxI?fs=1&amp;hl=en_US" quality="low"><param name="quality" value="low"></object>', 'Мы сняли клип на песню "про диму и петю"!'),
(3, '<iframe height="390" frameborder="0" width="480" allowfullscreen="" src="http://www.youtube.com/embed/1A4zZmHCv8k" title="YouTube video player"></iframe>', '"Кадриль", видео с концерта'),
(4, '<object height="360" width="640">\r\n<param value="http://www.youtube.com/v/YbBU06irWT8?version=3&amp;hl=en_US" name="movie">\r\n<param value="true" name="allowFullScreen">\r\n\r\n<param value="always" name="allowscriptaccess">\r\n<embed height="360" width="640" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" src="http://www.youtube.com/v/YbBU06irWT8?version=3&amp;hl=en_US" quality="low"><param name="quality" value="low"></object>', 'Новый клип "про ивана groove"'),
(5, '<object height="360" width="640"><param value="http://www.youtube.com/v/eIa7ZfJUeGU?version=3&amp;hl=en_US" name="movie">\r\n\r\n<param value="true" name="allowFullScreen">\r\n\r\n<param value="always" name="allowscriptaccess">\r\n<embed height="360" width="640" allowfullscreen="true" allowscriptaccess="always" type="application/x-shockwave-flash" src="http://www.youtube.com/v/eIa7ZfJUeGU?version=3&amp;hl=en_US" quality="low"><param name="quality" value="low"></object>', 'Третий официальный видеоклип фолк-группы Отава Ё, песня на стихи Даниила Хармса. Снято в марте 2012 года во дворе музея Анны Ахматовой, в Санкт-Петербурге');
SET FOREIGN_KEY_CHECKS=1;
