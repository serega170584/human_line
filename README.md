# Delivery service

- [Install docker](https://docs.docker.com/engine/install/)
- `git clone https://github.com/serega170584/human_line.git`
- `cd human_line`
- `docker-compose up -d`
- `docker-compose run app composer install`
- Get list of delivery companies offers: `http://localhost:3900/delivery?target_kladr={val}&weight={val}&source_kladr={val}`
- Add order to delivery company offers: `http://localhost:3900/delivery?target_kladr={val}&weight={val}&source_kladr={val}&uuid={val}`.
Notice: You can find uuid of delivery in `human_line/project/config/services.yaml`. For example in `food.company` section 
