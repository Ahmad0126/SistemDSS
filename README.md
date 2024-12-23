# SistemDSS

## About
SistemDSS is a part of **Decision Support System** that focus on **data visualization**. It allows users to customize their database and visualize the data into charts using **sql query**. Every chart can be published so that people can see and explore many scenarios of data. It also can be embed into `<iframe>` so that people can show the chart in their websites.

## Chart types

SistemDSS provides 5 types of chart to visualize data:
- Bar
- Line
- Scatter
- Pie
- Radar

## Query Limitations

You may found some limitations when running a query because SistemDSS is made as secure as possible but still simple. Here are queries that allowed to run:
- `INSERT`
- `SELECT`
- `UPDATE`
- `DELETE`
- `CREATE TABLE`
- `ALTER TABLE`
- `DROP TABLE`

Any query except those queries are not allowed to run. Other limitation is that you can only run 1 of those query at a time.


## License

The SistemDSS is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
