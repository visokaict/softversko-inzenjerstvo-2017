# Slam Jam - game jam project
---
> Slam Jam je web aplikacija koja se kreira kako bi se omogucilo odrzavanje Game Jam event-ova kao i ucestvovanje u istim. Game Jam je bitan jer spaja neciju ideju sa ljudima koji mogu da je ostvare. Poenta je da kreatori npreduju u radu i razvoju svojih igara, kao i posmatrajuci druge projekte koje su drugi ucesnici napravili.

---

##### Business spec
User dolazi na sajt kako bi video sta sve aplikacija ima. Posto je on neulogovan, nema ogroman broj funkcionalnosti ali  ima ono zbog cega je i dosao prvobitno a to je razgledanje Game Jam event-ova i Game Submission-a, kao i pretrazivanje istih. Bice mu prikazana mogucnost da hostuje Game Jam event i da se prijavi na neki kao i da glasa za Game Submission i ostavlja komentare kao i mogucnost da proba iste, ali ce ga to sve voditi na **Login page** kako bi te funkcionalnosti otkljucao.
Ako User nema nalog da se uloguje, postoji mogucnost registracije na kojoj mora da popuni neke licne stvari kao i da izabere da li zeli da bude Jam Maker, Jam Developer, oba ili nista od toga.
-- Ako ne zeli neke od rola znaci da zeli samo da probava Game Submission-e i da mozda komentarise i glasa.
-- Ako izabere da zeli da bude Jam Maker, otvara mu se mogucnost za kreiranje novih Game Jam event-ova koji bi trebali da opisu taj event, kao i pregledanje i filtriranje svojih event-ova. Na kraju svakog Game Jam event-a sistem sam bira pobednika ali ukoliko postoji vise Game Submission-a na prvom mestu, Jam Maker mora da se odluci za prvo mesto. Jam Maker prilikom kreiranja Game Jam-a moze da izabere da li zeli da omoguci ostalima da glasaju za Game Submition-e.
-- Ako izabere Jam Developer ulogu, sada User moze da se prijavi na neki od Game Jam event-ova i da na istim i ucestvuje. Pre kraja event-a Jam Developer bi trebalo da submit-uje svoj projekat kako bi drugi ili samo Jam Maker ocenio taj projekat po nekim kriterijumima vec zadatim od strane Jam Maker-a.
> Ako bilo ko primeti nesto odstupa od pravila **sajta**, ima mogucnost da prijavi to **Admin-ima** kako bi oni mogli da pravilno reaguju.

---

#### Developer spec (usecase)
Kao Developer zelim da system ima uloge
-	Admin (regulise sve moguce aktivnosti u okviru website-a)
-	JamDeveloper (prijvaljuje na jam-ove I da uploaduje file na taj prijavljeni jam event)
-	JamMakere (stvara jam evente I odredjuju pobednika na kraju event-a)

Kao anonimni user ja zelim
-	Da se registrujem na sajt
-	Da se logujem na sajt
-	Da napravim zahtev za reset password-a
-	Da vidim listu game jam-ova
-	Da filtriram game jam-ove
-	Da vidim pojedinacan game jam
-	Da vidim all game submissions
-	Da filtriram all game submissions
-	Da vidim pojedinacan game submission

Kao logovani user zelim
-	Da se odlogujem
-	Da probam game submission [skinuti]
-	Da ostavljam komentare na game submissions
-	Da mogu da glasam ako je dopusteno na game submissions
-	Da glasam za Bedz
-	Da promenim password
-	Da promenim svoje informacije
-	Da napravim report za game submission

Kao JamDeveloper zelim
-	Da se prijavim na jam event
-	Da se odjavim sa jam event-a
-	Da napravi game submission za game jam event
-	Da editujem game submission pre kraja jam event-a
-	Da obrisem game submission pre kraja jam event-a
-	Da vidim sve svoje game submission-e

Kao JamMaker zelim
-	Da napravim novi jam event
-	Da editujem jam event pre pocetka
-	Da obrisem jam event pre pocetka
-	Da izaberem jam pobednika kada zavrsi jam event

Kao Admin zelim
-   Da dodam Admin ulogu korisniku
-   Da uklonim Admin ulogu korisniku
-   Da dodam Poll
-   Da editujem Poll
-   Da obrisem Poll
-   Da block-ujem Usera
-   Da unblock-ujem Usera
-   Da block-ujem Game Jam
-   Da unblock-ujem Game Jam
-   Da block-ujem Game Submission
-   Da unblock-ujem Game Submission
-   Da dodam Bedz
-   Da editujem Bedz
-   Da obrisem Bedz
-   Da obrisem Bedz sa Game Submission-a
-   Da zatvorim Report kada ga obradim
-   Da dodam Kategoriju
-   Da editujem Kategoriju
-   Da obrisem Kategoriju
-   Da dodam Criteria
-   Da editujem Criteria
-   Da obrisem Criteria
-   Da dodam ImageCategory
-   Da editujem ImageCategory
-   Da obrisem ImageCategory

---

#### Usecase diagram
![alt text](https://i.imgur.com/aQg1ncJ.png "Ovo je usecase slika")

---

#### Game Jams mockup page
![alt text](https://i.imgur.com/78bHHje.png "Ovo je prva slika mockup-a")

---

#### Models spec
_(Every object has own id)_

User
-	Email [String]
-	Password [Hash]
-	Username [String]
-	Created at [Date]
-	Updated at [Date]
-	Avatar [Image]
-	Uloge [array Uloga]
-	isBanned [bool]
-	Access Token [String (Token)]

Uloga
-	Naziv [String]
-	Text [String]
-	Is available for user [bool]
-	Description [String]

GameJam
-	Title [String]
-	Description [Textarea]
-	Cover image [Image]
-	Start date [Date]
-	End date [Date]
-	Voting End date [Date]
-	Content [Markdown]
-	Criterias [array Criteria]
-	Lock submitions after submitting [bool]
-	Others can vote [bool]
-	isBlocked [bool]
-	UserId [int]
-	Number of views [int]
-	Created At [Date]
-	Participants [array Users]

Game Submition
-	GameJamId [Int]
-	Tizer slika [Image]
-	Original slika [Image]
-	Title [String]
-	UserId [Int]
-	Desctiption [Markdown]
-	CreatedAt [Date]
-	EditedAt [Date]
-	DownloadableFiles [array DownloadFile]
-	Num of Viewes [Int]
-	Num of Downloads [int]
-	Rating [Float (0-10)]
-	Num of Downloads [Int]
-	Number of Votes [int]
-	Sum of Votes [int]
-	ScreenShots [array Image]
-	Bages [array Bage]
-	Kategorije [array Kategorija]
-	Komentari [array Comments]
-	Reports [array Reports]
-	Votes [array PullVotes]
-	isBlocked [bool]
-	Is Winner [bool]

Commnets
-	GameSubmitionId [Int]
-	Text [String]
-	UserId [Int]
-	CreatedAt [Date]
-	EditedAt [Date]

Criteria
-   Name [String]
-   Description [String]

Kategorija
-   Name [String]

Bages
-	Name [String]
-	Image [Image]

Report
-   ReportObjectId [Int]
-   Reason [String]
-   UserId [Int]
-   CreatedAt [Date]
-   is Solved [bool]

Images
-   Alt [String]
-   Path [String]
-   ImageCategory [ImageCategory]
-   Created At [Date]

ImageCategory
-   Naziv [String]

DownloadFiles
-   Path [String]
-   Name [String]
-   Size [int]
-   Platform [Platform]
-   Created At [Date]
-   File Extension [String]
   
Platforms
-   Name [String]
-   Class Name For Icon [String]

---

#### Class Diagrams
![alt text](https://i.imgur.com/N1WzPtm.jpg "Klasni diagram Slam jam-a")

---

#### Used Templates

##### - Frontend Template 
![alt text](https://i.imgur.com/SkEyL73.jpg "Forntend template Slam jam-a")

##### - Admin panel Template 
![alt text](https://i.imgur.com/BZpGrKd.jpg "Admin panel template Slam jam-a")

---

#### Sitemap
```
<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
  <loc>https://slamjamphp.000webhostapp.com/</loc>
  <lastmod>2018-06-25T19:53:28+00:00</lastmod>
  <priority>1.00</priority>
</url>
<url>
  <loc>https://slamjamphp.000webhostapp.com/games</loc>
  <lastmod>2018-06-25T19:53:28+00:00</lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://slamjamphp.000webhostapp.com/about</loc>
  <lastmod>2018-06-25T19:53:28+00:00</lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://slamjamphp.000webhostapp.com/contact-us</loc>
  <lastmod>2018-06-25T19:53:28+00:00</lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://slamjamphp.000webhostapp.com/doc.pdf</loc>
  <lastmod>2018-06-24T21:40:15+00:00</lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://slamjamphp.000webhostapp.com/login</loc>
  <lastmod>2018-06-25T19:53:28+00:00</lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://slamjamphp.000webhostapp.com/register</loc>
  <lastmod>2018-06-25T19:53:28+00:00</lastmod>
  <priority>0.80</priority>
</url>
</urlset>
```

---

#### Website pages screenshots

##### - Frontend screenshots 
![alt text](https://i.imgur.com/dimffus.png "Screenshots 1")
![alt text](https://i.imgur.com/swqwQ4x.png "Screenshots 2")
![alt text](https://i.imgur.com/abk9Jmf.png "Screenshots 3")
![alt text](https://i.imgur.com/ZAep0oz.png "Screenshots 4")
![alt text](https://i.imgur.com/yOx7oeU.jpg "Screenshots 5")
![alt text](https://i.imgur.com/IScb4JK.png "Screenshots 6")
![alt text](https://i.imgur.com/aff6Dh1.png "Screenshots 7")
![alt text](https://i.imgur.com/JHBrDm5.png "Screenshots 8")
![alt text](https://i.imgur.com/sFY0QHv.png "Screenshots 9")
![alt text](https://i.imgur.com/qZQb0kE.png "Screenshots 10")
![alt text](https://i.imgur.com/KeY9grF.png "Screenshots 11")
![alt text](https://i.imgur.com/pUAeMHC.png "Screenshots 12")
![alt text](https://i.imgur.com/zSjVsZC.png "Screenshots 13")

---

##### - Admin panel screenshots 
![alt text](https://i.imgur.com/Lp2zjOI.png "Screenshots 1")
![alt text](https://i.imgur.com/Jy3UOSN.png "Screenshots 2")
![alt text](https://i.imgur.com/MOVqAQG.png "Screenshots 3")
![alt text](https://i.imgur.com/UrmSf2a.png "Screenshots 4")
![alt text](https://i.imgur.com/p4ypapv.png "Screenshots 5")
![alt text](https://i.imgur.com/KXuCd8I.png "Screenshots 6")
![alt text](https://i.imgur.com/Qc29b7X.png "Screenshots 7")
![alt text](https://i.imgur.com/VjI18tN.png "Screenshots 8")
![alt text](https://i.imgur.com/ggYIZaN.jpg "Screenshots 9")
![alt text](https://i.imgur.com/I9CDHZH.png "Screenshots 10")
![alt text](https://i.imgur.com/zWMBSlt.png "Screenshots 11")

---

#### Design database tables diagram
![alt text](https://i.imgur.com/DmnxQTy.png "Slam jam database diagram")

---

#### Source Code

[Github - Link to Source Code](https://github.com/visokaict/softversko-inzenjerstvo-2017)
> This is school github repository
And there is /source.txt file on server just in case
its to big for this documentation and ugly


---

#### Literature
1.  Jon Duckett, Web Design with HTML, CSS, JavaScript and jQuery Set 1st Edition, 2014
2.  Larry Ullman, PHP and MySQL for Dynamic Web Sites: Visual QuickPro Guide (5th Edition) 5th Edition, 2017
3.  Riwanto Megsinarso, Step By Step Bootstrap 3: A Quick Guide to Responsive Web Development Using Bootstrap 3, 2014
4.  Matt Stauffer, Laravel: Up and Running: A Framework for Building Modern PHP Apps 1st Edition, 2016