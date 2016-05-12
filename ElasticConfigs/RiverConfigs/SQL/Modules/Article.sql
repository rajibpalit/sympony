SELECT
    A.`id`                                                                                       AS '_id',
    A.`abstract`                                                                                 AS 'abstract',
    A.`account_id`                                                                               AS 'accountId',
    A.`author`                                                                                   AS 'author.name',
    A.`author_url`                                                                               AS 'author.url',
    A.`avg_review`                                                                               AS 'averageReview',
    CONCAT_WS(
        ' ',
        CASE WHEN A.cat_1_id THEN CONCAT('A:', A.cat_1_id) END,
        CASE WHEN A.cat_2_id THEN CONCAT('A:', A.cat_2_id) END,
        CASE WHEN A.cat_3_id THEN CONCAT('A:', A.cat_3_id) END,
        CASE WHEN A.cat_4_id THEN CONCAT('A:', A.cat_4_id) END,
        CASE WHEN A.cat_5_id THEN CONCAT('A:', A.cat_5_id) END
    )                                                                                            AS 'categoryId',
    A.`friendly_url`                                                                             AS 'friendlyUrl',
    A.`level`                                                                                    AS 'level',
    IF(A.`publication_date` = '0000-00-00', NULL, DATE_FORMAT(A.`publication_date`, '%Y-%m-%d')) AS 'publicationDate',
    ARC.`reviewCount`                                                                            AS 'reviewCount',
    A.`fulltextsearch_keyword`                                                                   AS 'searchInfo.keyword',
    if(A.`status` = 'A', 1, 0)                                                                   AS 'status',
    A.`fulltextsearch_keyword`                                                                   AS 'suggest.what.input',
    A.`title`                                                                                    AS 'suggest.what.output',
    CONCAT(A.`friendly_url`, '|article')                                                         AS 'suggest.what.payload',
    90                                                                                           AS 'suggest.what.weight',
    AI.`thumbnail`                                                                               AS 'thumbnail',
    A.`title`                                                                                    AS 'title',
    A.`number_views`                                                                             AS 'views'
FROM Article AS A
    LEFT JOIN
    (
        SELECT
            id,
            CONCAT(`prefix`, 'photo_', id, '.', LOWER(`type`)) AS thumbnail
        FROM Image
    ) AS AI
        ON AI.id = A.image_id
    LEFT JOIN
    (
        SELECT
            item_id  AS id,
            COUNT(*) AS reviewCount
        FROM Review
        WHERE item_type = 'article' AND approved = 1
        GROUP BY item_id
    ) AS ARC
        ON ARC.id = A.id
