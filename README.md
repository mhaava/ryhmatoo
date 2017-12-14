# PicUp
Veebirakenduse pilt:
https://drive.google.com/a/tlu.ee/file/d/1dBKYV5eW1oduFqE5WbqiA_f2PPpgAxJe/view?usp=sharing

Mihkel Haava, Andrus Aun, Marii Helena Keerig

Meie lehele saavad inimesed pilte üles laadida ilma, et peaks looma eelnevalt kasutaja. Samuti on kõigil võimalik näha üleslaaditud pilte ning ise anda hinnang lemmikumatele piltidele.

Sihtrühmaks on igas vanuses inimesed, kellel on huvi piltide ja fotograafia vastu ning soovivad huvitavaid, kas enda tehtud või kuskilt leitud, pilte ka teistega jagada. Võrreldes teiste kohtadega on meil kohe näha kui palju pildi peal ka veel klikitud on.

Funktsionaalsus:
1. Saab lisada pilte
2. Saab näha teiste lisatud pilte
3. Saab neile oma hinnangu anda
4. Näeb palju on pilte klikitud.

Andmebaasi skeem:
https://drive.google.com/a/tlu.ee/file/d/1ihQtrVJ0_4L9Ck-mCkRAkTYfo00BsBE7/view?usp=sharing

SQL laused:
("SELECT id, filename, thumbnail, clicks, likes FROM pildid ORDER BY clicks DESC");
("UPDATE pildid SET clicks=clicks+1 WHERE id=?");
("SELECT * FROM likes WHERE ip_address = ? AND pic_id = ?");
("UPDATE pildid SET likes=likes+1 WHERE id=?");
("INSERT INTO likes (pic_id, ip_address) VALUES (?, ?)");

Kokkuvõte (mida õppisin juurde, mis ebaõnnestus, mis oli keeruline):

Mihkel- Oluliselt midagi juurde ei õppunud, pigem kinnistasin oma teadmisi. Keeruline oli likeide lisamine.
Andrus - õppisin PHPd juurde, keeruline oli kommentaaride lisamine.
Marii- Õppisin üldiselt juurde veebiprogrammeerimise kohta ning hakkasin asjadest paremini aru saama kui enne. Vahepeal ebaõnnestusid mõned asjad, kuid need said veidi aja pärast ilusti siiski tehtud. Keeruline oli koodi kirjutamine, kui täpselt ei mõistnud kõige tähendust.
