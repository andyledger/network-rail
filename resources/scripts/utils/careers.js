export function reduceElements(careers, value) {
  let uniqueElements = [];

  careers.forEach(job => {
    uniqueElements.push(job[value]);
  });

  // reduce array
  uniqueElements = uniqueElements.filter(
    (job, index) => uniqueElements.indexOf(job) === index
  );

  // remove empty item
  if (uniqueElements.includes("")) {
    uniqueElements.splice(uniqueElements.indexOf(""), 1);
  }

  uniqueElements.push("All");

  return uniqueElements;
}

export function mapColumns(column) {
  if (column === 'Position') {
    return 'DISPLAYED_JOB_TITLE';
  }

  if (column === 'Location') {
    return 'TOWN_OR_CITY';
  }

  if (column === 'Salary') {
    return 'MAX_SALARY';
  }

  if (column === 'Business Function') {
    return 'FUNCTION';
  }

  if (column === 'Closing') {
    return 'VAC_ADVERTISE_END_DATE';
  }
}

export function getDistanceFromLatLonInMiles(lat1, lon1, lat2, lon2) {
  const R = 6371; // Radius of the earth in km
  const dLat = deg2rad(lat2 - lat1); // deg2rad below
  const dLon = deg2rad(lon2 - lon1);
  const a =
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(deg2rad(lat1)) *
    Math.cos(deg2rad(lat2)) *
    Math.sin(dLon / 2) *
    Math.sin(dLon / 2);

  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  const d = R * c * 0.621371; // Distance in miles
  return d;
}

export function formatDate(value) {
  let date = new Date(value);

  let mounth = date.getMonth() + 1;

  return date.getDate() + "/" + mounth + "/" + date.getFullYear();
}

export function formatCurrency(value) {
  const formatter = new Intl.NumberFormat("en-UK", {
    style: "currency",
    currency: "GBP",
    minimumFractionDigits: 0
  });

  return formatter.format(value);
}

export function deg2rad(deg) {
  return deg * (Math.PI / 180);
}

export function positionFormat(lat, long) {
  return {
    lat: parseFloat(lat),
    lng: parseFloat(long)
  };
}

/**
 * Filter the careers Array based on the next filters:
 *
 * @param  {Array}   careers
 * @param  {String}  employment
 * @param  {String}  jobType
 * @param  {String}  keywords
 * @param  {Boolean} isSalaryActive
 * @param  {Object}  salary
 * @param  {Boolean} isValidPostcod
 * @param  {Number}  latitude
 * @param  {Number}  longitude
 * @param  {Number}  radius
 * @return {Array}
 */
export function filterCareers(careers, employment, jobType, keywords, isSalaryActive, salary, isValidPostcode, latitude, longitude, radius) {
  // filter by employment status
  careers = careers.filter(job => {
    if (employment == "All") {
      return true;
    }

    return employment == job.EMPLOYEEMENT_STATUS;
  });

  // filter by jobType status
  careers = careers.filter(job => {
    if (jobType === "All") {
      return true;
    }

    return jobType === job.FUNCTION;
  });

  // filter by Keywords
  careers = careers.filter(job => {
    if (keywords == "") {
      return true;
    }

    let str =
      job.SEARCH_ATTR_7.toLowerCase() +
      job.TOWN_OR_CITY.toLowerCase() +
      job.JOB_FUNCTION.toLowerCase() +
      job.FUNCTION.toLowerCase() +
      job.VACANCY_CONTEXT.toLowerCase() +
      job.DISPLAYED_JOB_TITLE.toLowerCase() +
      job.VACANCY_NAME.toLowerCase();

    return str.includes(keywords.toLowerCase());
  });

  // filter by radius
  careers = careers.filter(job => {
    if (!isValidPostcode) {
      return true;
    }

    return (
      getDistanceFromLatLonInMiles(
        job.LATITUDE,
        job.LONGITUDE,
        latitude,
        longitude
      ) <= radius
    );
  });

  // filter by salary
  careers = careers.filter(job => {
    if (!isSalaryActive) {
      return true;
    }

    if (salary[1] == 90) {
      return parseInt(job.MIN_SALARY) >= salary[0] * 1000;
    }

    return (
      parseInt(job.MIN_SALARY) >= salary[0] * 1000 &&
      salary[1] * 1000 >= parseInt(job.MAX_SALARY)
    );
  });

  return careers;
}

/**
 * Slice an array of items base on a page size
 * @param  {integer} pageNumber      Number of the page to display
 * @param  {array}   arrayItems
 * @param  {integer} pageSize
 * @return {array}
 */
export function paginateArray(pageNumber = 1, arrayItems = [], pageSize = 20) {
  const indexStart = (pageNumber - 1) * pageSize;

  const indexEnd = pageNumber * pageSize - 1;

  return arrayItems.slice(indexStart, indexEnd);
}

export const salarySliderConfig = {
  railStyle: {
    background: "#ccc",
    height: "6px",
    borderRadius: "10px"
  },
  processStyle: {
    background: "#E56430"
  },
  min: 0,
  max: 90,
  marks: true,
  interval: 10,
  minRange: 10,
  tooltip: "none",
  dotStyle: {
    width: "25px",
    height: "25px",
    border: "5px solid #fff",
    background: "#E56430",
    position: "relative",
    top: "-5px",
    borderRadius: "50%"
  }
};

export const radiusSliderConfig = {
  railStyle: {
    background: "#ccc",
    height: "6px"
  },
  processStyle: {
    background: "#E56430"
  },
  stepStyle: {
    background: "#dadada",
    height: "20px",
    width: "1px",
    top: "-7px",
    left: "1px"
  },
  min: 0,
  max: 150,
  marks: val => (val % 30 === 0 ? { label: `${val}` } : { label: "" }),
  interval: 10,
  tooltip: "none",
  dotStyle: {
    width: "25px",
    height: "25px",
    border: "5px solid #fff",
    background: "#E56430",
    position: "relative",
    top: "-5px",
    borderRadius: "50%"
  }
};

export const defaultSliderConfig = {
  railStyle: {
    background: "#ccc",
    height: "6px"
  },
  processStyle: {
    background: "#E56430"
  },
  stepStyle: {
    background: "#dadada",
    height: "20px",
    width: "1px",
    top: "-7px",
    left: "1px"
  },
  tooltip: "none",
  dotStyle: {
    width: "25px",
    height: "25px",
    border: "5px solid #fff",
    background: "#E56430",
    position: "relative",
    top: "-5px",
    borderRadius: "50%",
    // boxShadow: "1px 1px 1px 1px #000000"
  }
};
